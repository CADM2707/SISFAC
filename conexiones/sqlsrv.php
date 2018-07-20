
<?php

    function connection_object()
    {
        $serverName = '10.13.211.240'; //IP DEL SERVIDOR
        $connectionOptions = array(
            'Database' => 'Facturacion',
            'Uid' => 'sa',
            'PWD' => 'S1st3m4s'
        );
        $conn = sqlsrv_connect($serverName, $connectionOptions);

        if($conn){
            return $conn;
        }else{
            die(format_errors(sqlsrv_errors()));
        }
    }
        

    function format_errors( $errors )
    {
        echo "Error information: ";

        foreach ( $errors as $error )
        {
            echo "SQLSTATE: ".$error['SQLSTATE']."\n";
            echo "Code: ".$error['code']."\n";
            echo "Message: ".$error['message']."\n";
        }
    }
