<?php

/**
 * 
 */
class DatabaseController
{
    /* @var AlexaRequest */
    private $request;

    private $dbConnection;

    const tableName = "echo_skill_vrs__user";

    public function __construct(AlexaRequest $request)
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

    public function getUserAttributes()
    {
        $userId = $this->request->getUserId();
        $userJson = $this->_loadUserJson($userId);
        if(strlen($userJson) > 0 && is_array(json_decode($userJson, $pAssoc=true))) {
            $user = new UserAttributesEntity($userJson);
        } else {
            // Generate a default User
            $user = new UserAttributesEntity();
            $user->setUserId($userId);
        }
        $this->_saveUserJson($user);
        return $user;
        // return new UserAttributesEntity($userJson);
    }
    public function setUserAttributes(UserAttributesEntity $user)
    {
        $this->_saveUserJson($user);
    }

    /*
     * Helper Methods
     */

    // Dump request to Log Database
    private function _logRequest() {
        $entityBody = $this->request->getEntityBody();
        $entityBody = json_encode ( $entityBody, JSON_PRETTY_PRINT );
        $sql = "INSERT INTO `skill-dev-logging` (`request`)
                VALUES ('".mysqli_real_escape_string ( $this->dbConnection, $entityBody ) ."')";
        mysqli_query($this->dbConnection, $sql);
    }

    // Load Data from Query to Array
    private function _loadSqlToArray(string $sql) {
        $result = mysqli_query($this->dbConnection, $sql, MYSQLI_USE_RESULT);

        $resultSet = array();
        while($row = $result->fetch_assoc()) {
            $resultSet[] = $row;
        }

        return $resultSet;
    }

    // Load User-JSON from Database
    private function _loadUserJson(string $userId) {
        $sql = "SELECT userAttributes FROM ".self::tableName." WHERE id = '".mysqli_real_escape_string($this->dbConnection, $userId)."'";
        $r = $this->_loadSqlToArray($sql);
        if(count($r) > 0 && is_array($r[0])) {
            return $r[0]['userAttributes'];
        } else {
            return false;
        }
    }
    // Write User-JSON to Database
    private function _saveUserJson(UserAttributesEntity $user) {
        $userId = $user->getUserId();
        $sql = "REPLACE INTO ".self::tableName."(id, userAttributes) VALUES ('".mysqli_real_escape_string($this->dbConnection, $userId)."', '".mysqli_real_escape_string($this->dbConnection, $user)."')";
        mysqli_query($this->dbConnection, $sql);
    }


}