
<?php

require_once('database.php');

$fuels = $_GET['fuels'];

$sql = "
    SELECT
        *
    FROM
        `records`
    WHERE
        `records.fuelID` = '" . $_POST["records"] . "'";
        // AND `franchise` = '". $_POST["franchise"] ."'
        // AND `unfalleinschluss` LIKE '" . $_POST["unfall"] . "'";

// $tbs = array();

foreach( $fuels as $fuel )
{
    if ( empty( $_POST[$fuel] ) ) continue;

    $fuels[] = "`fuelID` = '" . $_POST[$fuel] . "'";
}
if ( !empty( $fuels ) )
{
    $sql .= ' AND ( ' . implode( ' AND ', $fuels ) . ' )';
}
$sql .= " ORDER BY recordID";

echo $sql;

$res = mysqli_query($con, $sql) or die( mysql_error() );
$num = mysqli_num_rows($res);
if ($num==0) echo "Keine Datensätze gefunden";

while ($dsatz = mysqli_fetch_assoc($res)) {
    echo $dsatz["versicherungsnamen"].
    // .$dsatz["records.fuelID"] . ", "
    // .$dsatz["tarif-typ"] . ", "
    // .$dsatz["unfalleinschluss"] . ","
    // . $dsatz["praemie"] . 
    "<br />";
}
mysqli_close($con);

?>