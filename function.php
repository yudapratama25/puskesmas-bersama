<?php

date_default_timezone_set("Asia/Kuala_Lumpur");

    function includeWithVariables($filePath, $variables = [], $print = true) {
        $output = null;

        if (file_exists($filePath)) {
            //Ekstrak Variable ke namespace local
            extract($variables);

            // Memulai output Buffering
            ob_start();

            // Include Templatenya
            require_once $filePath;

            // Akhir Output Buffering
            $output = ob_get_clean();
        }

        if ($print) {
            print $output;
        }

        return $output;
     }

    function calculate_age($tanggal_lahir){
        $birthDate = new DateTime($tanggal_lahir);
        $today = new DateTime("today");
        if ($birthDate > $today) { 
            exit("0 tahun 0 bulan 0 hari");
        }
        $years = $today->diff($birthDate)->y;
        return $years;
    }

?>