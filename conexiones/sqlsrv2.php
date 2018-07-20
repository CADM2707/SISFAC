
<?php

    function connection_object2()
    {
        $serverName = '10.13.211.240'; //IP DEL SERVIDOR
        $connectionOptions = array(
            'Database' => 'Procesos_de_Personal',
            'Uid' => 'OpProcesoPersonal',
            'PWD' => 'P3r$0n4l'
        );
        $conne = sqlsrv_connect($serverName, $connectionOptions);

        if($conne){
            return $conne;
        }else{
            die(format_errors2(sqlsrv_errors()));
        }
    }
        

    function format_errors2( $errors )
    {
        echo "Error information: ";

        foreach ( $errors as $error )
        {
            echo "SQLSTATE: ".$error['SQLSTATE']."\n";
            echo "Code: ".$error['code']."\n";
            echo "Message: ".$error['message']."\n";
        }
    }
