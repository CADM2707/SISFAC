
<?php

    function connection_object3()
    {
        $serverName = '10.13.211.240'; //IP DEL SERVIDOR
        $connectionOptions = array(
            'Database' => 'VENTANILLA',
            'Uid' => 'opVentanilla',
            'PWD' => 'V38n07'
        );
        $connec = sqlsrv_connect($serverName, $connectionOptions);

        if($connec){
            return $connec;
        }else{
            die(format_errors3(sqlsrv_errors()));
        }
    }
        

    function format_errors3( $errors )
    {
        echo "Error information: ";

        foreach ( $errors as $error )
        {
            echo "SQLSTATE: ".$error['SQLSTATE']."\n";
            echo "Code: ".$error['code']."\n";
            echo "Message: ".$error['message']."\n";
        }
    }
