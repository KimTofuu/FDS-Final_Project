<?php
//sql to retrieve member email and name, or pati sa coach
//para sa windows task scheduler, execute and one yung server muna, then execute yung file, pwede during runtime nalang ng server yung testing]
require_once __DIR__ . '/../composerDep/vlucas/vendor/autoload.php';
require_once __DIR__ . '/../composerDep/phpmailer/vendor/autoload.php';
require_once($apiPath . '/interfaces/phpmailer.php');

use Dotenv\Dotenv;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

class Mailer implements phpmailerInterface{
    protected $pdo, $gm;
    private $mail;

    public function __construct(\PDO $pdo, ResponseMethodsProj $gm)
    {
        $this->pdo = $pdo;
        $this->gm = $gm;
        $this->mail = new PHPMailer(true);
        $this->setupSMTP();
    }

    private function setupSMTP()
    {
        try {
            // Server settings
            $this->mail->SMTPDebug = SMTP::DEBUG_OFF; // Set to SMTP::DEBUG_SERVER for detailed debugging                      
            $this->mail->isSMTP();                                            
            $this->mail->Host       = 'smtp.gmail.com';                     
            $this->mail->SMTPAuth   = true;                                  
            $this->mail->Username   = 'olympusgymms@gmail.com';               
            $this->mail->Password   = $_ENV['googleSMTPpassword'];
            $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;        
            $this->mail->Port       = 587;

            // Sender information
            $this->mail->setFrom('OlympusGymManagement@gmail.com', 'Olympus Gym Manager');
        } catch (Exception $e) {
            echo "SMTP setup failed: {$this->mail->ErrorInfo}";
        }
    }

    public function addRecipient($email, $name){
        try {
            $this->mail->addAddress($email, $name);
        } catch (Exception $e) {
            echo "Failed to add recipient: {$this->mail->ErrorInfo}";
        }
    }

    public function sendReminder($subject, $htmlBody, $altBody)
    {
        try {
            // Content
            $this->mail->isHTML(true);                                  
            $this->mail->Subject = $subject;
            $this->mail->Body    = $htmlBody;
            $this->mail->AltBody = $altBody;

            $this->mail->send();

            $this->mail->clearAddresses();
            return $this->gm->responsePayload(null, 'success', 'Message has been sent', 200);
        } catch (Exception $e) {
            $this->mail->clearAddresses();
            return $this->gm->responsePayload(null, 'error', "Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}", 500);
        }
    }

    public function Expiry()
    {
        $sql = "SELECT m.Username, m.Email
                FROM member m
                JOIN membership_duration md ON m.User_ID = md.User_ID
                WHERE DATEDIFF(md.expiryDate, NOW()) <= 3
                AND DATEDIFF(md.expiryDate, NOW()) >= 0;
                ";

        try {
            $stmt = $this->pdo->prepare($sql);
            if ($stmt->execute()) {
                $members = $stmt->fetchAll();
                $recipients = [];


                if ($stmt->rowCount() > 0) {
                    foreach ($members as $member) {
                        $this->addRecipient($member['Email'], $member['Username']);
                    }
                    $result = $this->sendReminder(
                        'This is a REMINDER!',
                        '<p>Hello our valued customers! This is a reminder that your <strong>membership is about to expire within 3 days</strong>. Please process your payment immediately if you wish to continue your membership. Thank You!</p>',
                        'Hello our valued customers! This is a reminder that your membership is about to expire within 3 days. Please process your payment immediately if you wish to continue your membership. Thank You!'
                    );

                    if ($result['status'] === 'success') {
                        $recipients[] = [
                            "Recipient Username"=> $member['Username'],
                            "Recipient Email"=> $member['Email']
                        ];
                    }
                    return $this->gm->responsePayload($recipients, 'success', 'Reminders sent successfully.', 200);
                } else {
                    return $this->gm->responsePayload(null, 'failed', 'No members with expiring memberships found.', 404);
                }
            }
        } catch (PDOException $e) {
            return $this->gm->responsePayload(null, 'error', $e->getMessage(), 500);
        }
    }

    public function Session(){
        
        $sql = "SELECT m.Username, m.Email, c.CoachName, c.CoachEmail
                FROM gymsession gs
                JOIN coach c ON gs.Coach_ID = c.Coach_ID
                JOIN member m ON gs.User_ID = m.User_ID
                WHERE DATEDIFF(gs.date, NOW()) <= 1
                AND DATEDIFF(gs.date, NOW()) >= 0;
                ";

        try {
            $stmt = $this->pdo->prepare($sql);
            if ($stmt->execute()) {
                $members = $stmt->fetchAll();

                if ($stmt->rowCount() > 0) {
                    foreach ($members as $member) {
                        // Send reminder to the user
                        $this->addRecipient($member['Email'], $member['Username']);
                        $userResult = $this->sendReminder(
                            'Upcoming Gym Session Reminder!',
                            '<p>Hello ' . $member['Username'] . ',</p>
                             <p>This is a reminder that you have a gym session scheduled tomorrow with your coach, <strong>' . $member['CoachName'] . '</strong>.</p>
                             <p>Thank you, and we look forward to seeing you!</p>',
                            'Hello ' . $member['Username'] . ', This is a reminder that you have a gym session scheduled tomorrow with your coach, ' . $member['CoachName'] . '. Thank you, and we look forward to seeing you!'
                        );
    
                        // Send reminder to the coach
                        $this->addRecipient($member['CoachEmail'], $member['CoachName']);
                        $coachResult = $this->sendReminder(
                            'Upcoming Gym Session Reminder!',
                            '<p>Hello Coach ' . $member['CoachName'] . ',</p>
                             <p>This is a reminder that your client, <strong>' . $member['Username'] . '</strong>, has a gym session scheduled for tomorrow.</p>
                             <p>Thank you for your continued support!</p>',
                            'Hello Coach ' . $member['CoachName'] . ', This is a reminder that your client, ' . $member['Username'] . ' has a gym session scheduled for tomorrow. Thank you for your continued support!'
                        );
    
                        // Check if reminders were sent successfully
                        if ($userResult['status'] !== 'success' || $coachResult['status'] !== 'success') {
                            return $this->gm->responsePayload(array("Recipient Member Name" => $member['Username'], "Recipient Member Email" => $member['Email'], "Recipient Coach Name" => $member['CoachName'], "Recipient Coach Email" => $member['CoachEmail']), 'success', 'Reminders sent successfully.', 200);
                        }
                    }
                } else {
                    return $this->gm->responsePayload(null, 'failed', 'No members with expiring memberships found.', 404);
                }
            }
        } catch (PDOException $e) {
            return $this->gm->responsePayload(null, 'error', $e->getMessage(), 500);
        }
    }

    public function Alarm() {
        $sql = "SELECT m.Username, m.Email
                FROM member m
                JOIN gymalarm ga ON m.User_ID = ga.User_ID
                WHERE 
                (CASE 
                    WHEN DAYOFWEEK(CURDATE()) = 1 THEN ga.day = 'Monday'
                    WHEN DAYOFWEEK(CURDATE()) = 2 THEN ga.day = 'Tuesday'
                    WHEN DAYOFWEEK(CURDATE()) = 3 THEN ga.day = 'Wednesday'
                    WHEN DAYOFWEEK(CURDATE()) = 4 THEN ga.day = 'Thursday'
                    WHEN DAYOFWEEK(CURDATE()) = 5 THEN ga.day = 'Friday'
                    WHEN DAYOFWEEK(CURDATE()) = 6 THEN ga.day = 'Saturday'
                    WHEN DAYOFWEEK(CURDATE()) = 7 THEN ga.day = 'Sunday'
                END);";

        try {
            $stmt = $this->pdo->prepare($sql);
            if ($stmt->execute()) {
                $members = $stmt->fetchAll();

                if ($stmt->rowCount() > 0) {
                    foreach ($members as $member) {
                        $this->addRecipient($member['Email'], $member['Username']);
                        $result = $this->sendReminder(
                            'Gym Visit Reminder',
                            '<p>Hello ' . htmlspecialchars($member['Username']) . ',<br><br>This is a friendly reminder that you have scheduled a gym visit for tomorrow. We look forward to seeing you at the gym! Remember to bring your essentials and stay hydrated.<br><br>See you soon!</p>',
                            'Hello ' . htmlspecialchars($member['Username']) . ', This is a friendly reminder that you have scheduled a gym visit for tomorrow. We look forward to seeing you at the gym! Remember to bring your essentials and stay hydrated. See you soon!'
                        );

                        if ($result['status'] !== 'success') {
                            return $this->gm->responsePayload(
                                ["Recipient Name" => $member['Username'], "Recipient Email" => $member['Email']], 
                                'success', 
                                'Reminders sent successfully.', 
                                200
                            );
                        }
                    }
                } else {
                    return $this->gm->responsePayload(null, 'failed', 'No members with scheduled gym visits found for today.', 404);
                }
            }
        } catch (PDOException $e) {
            return $this->gm->responsePayload(null, 'error', $e->getMessage(), 500);
        }
    }


    public function coachSendMail($subject, $htmlBody, $altBody, $recipientEmail, $recipientName) {
        try {
            $this->mail->addAddress($recipientEmail, $recipientName);
            $this->mail->isHTML(true);
            $this->mail->Subject = $subject;
            $this->mail->Body = $htmlBody;
            $this->mail->AltBody = $altBody;
            $this->mail->send();
            $this->mail->clearAddresses();
            return $this->gm->responsePayload(null, 'success', 'Message sent successfully', 200);
        } catch (Exception $e) {
            $this->mail->clearAddresses();
            return $this->gm->responsePayload(null, 'error', "Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}", 500);
        }
    }
}


