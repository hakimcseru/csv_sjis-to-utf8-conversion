<?php 
/* 
This function i write to read a SJIS input file and output UTF-8 
@input shiftjis csv file
@output utf-8 csv file
@author M A Hakim
*/
function csv_sjis_to_utf8(){
    try {
    	// Read shiftjis csv file 
		$myfile = fopen("shiftjis.csv", "r") or die("Unable to open file!");
        // create output csv file to write
        $csvFileName = "tmp/".time() . rand() . '.csv';
        $res = fopen($csvFileName, 'w');

        if ($res === FALSE) {
            throw new Exception('You dont have permission to create/write a file');
        }
        // Loop per line until end-of-file
		while(!feof($myfile)) {
		  $dataInfo= fgets($myfile);

		    // Convert the SJIS string to UTF-8
            $dataInfo_out=mb_convert_encoding ($dataInfo , "UTF-8" , "ASCII,JIS,UTF-8,EUC-JP,SJIS");

            // Write the converted text into the output csv file
            fwrite($res, $dataInfo_out);
		}
		// Close shiftjis csv file 
		fclose($myfile);

        // Set download file name
        $fname = date('Y-m-d').'-'.'myname';

        // Close output csv file 
        fclose($res);

        // Send the file to header for download
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename='.$fname.'.csv');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . filesize($csvFileName));
        readfile($csvFileName);
        
    } catch(Exception $e) {
        // Error message
        echo $e->getMessage();
    }
    die;
    exit();
}
//Call the function
csv_sjis_to_utf8();

?>