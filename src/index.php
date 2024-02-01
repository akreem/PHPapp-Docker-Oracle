<?php

// Database credentials
$dbUsername = 'mydbase';
$dbPassword = 'korbaca2013';
$dbHost = '192.168.164.3';
$dbServiceName = 'PDB2';

// Build the connection string
$dbConnectionString = "(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST={$dbHost})(PORT=1521))(CONNECT_DATA=(SERVICE_NAME={$dbServiceName})))";

// Attempt to establish a connection
$conn = oci_connect($dbUsername, $dbPassword, $dbConnectionString);

// Prepare the statement
$stid = oci_parse($conn, 'SELECT * FROM personne');
if (!$stid) {
    $e = oci_error($conn);
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

// Perform the logic of the query
$r = oci_execute($stid);
if (!$r) {
    $e = oci_error($stid);
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

// Fetch the results of the query
print "<table border='1'>\n";
while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
    print "<tr>\n";
    foreach ($row as $item) {
        print "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
    }
    print "</tr>\n";
}
print "</table>\n";

oci_free_statement($stid);
oci_close($conn);

?>
