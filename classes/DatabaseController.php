<?php

/**
 * 
 */
class DatabaseController
{
    /* @var AlexaRequest */
    private $request;

    private $dbConnection;

    public function __construct($request)
    {
        if($request instanceof AlexaRequest) {
            $this->request = $request;
        } else {
            throw new BadMethodCallException(__METHOD__.": invalid AlexaRequest object");
        }
        $conn = mysqli_connect(MYSQL_SERVERNAME, MYSQL_USERNAME, MYSQL_PASSWORD, MYSQL_DBNAME);
        // Check connection
        if (!$conn) {
            throw new BadMethodCallException(__METHOD__. ": Connection failed: " . mysqli_connect_error());
        }
        // Set MySQL Connection Link to UTF-8
        mysqli_set_charset($conn, "utf8");

        $this->dbConnection = $conn;

        // Log the request, so we will be able to follow up on errors
        $this->_logRequest();
    }

    private function _logRequest() {
        $entityBody = $this->request->getEntityBody();
        $entityBody = json_encode ( $entityBody, JSON_PRETTY_PRINT );
        $sql = "INSERT INTO `skill-dev-logging` (`request`)
                VALUES ('".mysqli_real_escape_string ( $this->dbConnection, $entityBody ) ."')";
        mysqli_query($this->dbConnection, $sql);
    }


    public function getUserAttributes()
    {
        // TODO: load entry from database by userId passed from Echo
        return new UserAttributesEntity();
    }
    public function setUserAttributes()
    {
    }
}