<?php require('conn.php'); ?>
<html lang="en-US" style="height: 100%;">
<head>
<title>Populating a Select Box with PHP MySQL</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="Keywords" content="">
<meta name="Description" content="">
<!--script src="multiform.js"></script-->
</head>
<body>
    
<?php
/**
* Get the needed sql
*/
function get_read_sql($tbl)
{
    switch($tbl)
    {
        case 'tbl_states':
        default:
            $sql = 'SELECT *'
                .' FROM'
                    .' '.$tbl
                .' WHERE 1'
            ;
    }
    return $sql;
}


/**
*
* function to generate the options of a select boxes
*
* $tbl          is the table to generate values from
* $opt_value    is the name of the column to use for the option value property
* $opt_text     is the name of the column to use for the option text property
* $rid          is the record id representing the selected option
* $conn         is the database connector resource
*
*/

function select_box($tbl, $opt_value, $opt_text, $rid, $conn)
{
    // build the read query
    $sql = get_read_sql($tbl);
    
    // submit the query to generate rows
    $rs = mysql_query($sql, $conn) or die(mysql_error());
    
    // fetch the first 
    $row = mysql_fetch_assoc($rs);
    
    // calculate total rows
    $total_rows = mysql_num_rows($rs);
    
    // determine the selected option
    $sel = ($rid == 0) ? 'selected' : '';
    
    // initiate the options html
    $html = '<option value="0" '.$sel.'>--select--</option>';
    
    // loop throw the result count
    for ($i=0; $i<$total_rows; $i++)
    {
        // if the current options is the selected option then set the option's selected property
        $sel = ($row[$opt_value] == $rid) ? 'selected' : '';
        
        // append the current options html
        $html .= '<option value="'.$row[$opt_value].'" '.$sel.'>'.$row[$opt_text].'</option>';
        
        // generate the next row
        $row = mysql_fetch_assoc($rs);
    }
    
    // return the html
    return $html;
}

    
?>
    
<strong>Populating a Select Box with PHP MySQL</strong><br><br>
    
<?php
{
    
    // get the state
    $tbl = 'tbl_states';
    
    // get the selected state from the GET parameter
    $get_stid = mysql_real_escape_string($_GET['stid']);
    $get_stid = (strlen($get_stid) > 0) ? $get_stid : 0;
    
    $get_apid = mysql_real_escape_string($_GET['apid']);
    $get_apid = (strlen($get_apid) > 0) ? $get_apid : 0;
    
    $get_acid = mysql_real_escape_string($_GET['acid']);
    $get_acid = (strlen($get_acid) > 0) ? $get_acid : 0;
    
    // OR use a value from the MySQL index :: $row['state_id'];
}
?>
    
Country: 
<select id="state_id" name="state_id">
    <?php echo select_box('tbl_states', 'state_id', 'state_name', $get_stid, $conn); ?>
</select><br><br>
        
Airports: 
<select id="airport_id" name="airport_id">
    <?php echo select_box('tbl_airports', 'airport_id', 'airport_desc', $get_apid, $conn); ?>
</select><br><br>
        
Aircraft Type: 
<select id="aircraft_id" name="aircraft_id">
    <?php echo select_box('tbl_aircraft_types', 'aircraft_id', 'aircraft_model', $get_acid, $conn); ?>
</select><br><br>
        

    <hr>
    &copy; BlinkWIki
    
</body>
</html>