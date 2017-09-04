<?php
session_start();
require("../../../_database/db_tools.php");
//--------------------------------------------------------------------------------------------------
// This script reads event data from a JSON file and outputs those events which are within the range
// supplied by the "start" and "end" GET parameters.
//
// An optional "timezone" GET parameter will force all ISO8601 date stings to a given timezone.
//
// Requires PHP 5.2.0 or higher.
//--------------------------------------------------------------------------------------------------

// Require our Event class and datetime utilities
require dirname(__FILE__) . '/utils.php';

// Short-circuit if the client did not give us a date range.
if (!isset($_GET['start']) || !isset($_GET['end'])) {
    die("Please provide a date range.");
}

// Parse the start/end parameters.
// These are assumed to be ISO8601 strings with no time nor timezone, like "2013-12-29".
// Since no timezone will be present, they will parsed as UTC.
$range_start = parseDateTime($_GET['start']);
$range_end = parseDateTime($_GET['end']);

// Parse the timezone parameter if it is present.
$timezone = null;
if (isset($_GET['timezone'])) {
    $timezone = new DateTimeZone($_GET['timezone']);
}

// Read and parse our events JSON file into an array of event data arrays.
//$json = file_get_contents(dirname(__FILE__) . '/../json/events.json');

/*
$sql= "SELECT id, title, body, 
			DATE_FORMAT(start, '%Y-%m-%dT%H:%i' ) AS startTime, DATE_FORMAT(end, '%Y-%m-%dT%H:%i' ) AS endTime
		   FROM meeting_rooms_calendar
		   ORDER BY start DESC";
		   
	$result = mysql_query($sql, $link);
	
$events = array();

	while ($row = mysql_fetch_assoc($result)) {
	   $eventArray['id'] = $row['id'];
	   $eventArray['title'] =  $row['title'];
	   $eventArray['body'] =  $row['body'];
	   $eventArray['start'] = $row['startTime'];
	   $eventArray['end'] = $row['endTime'];
	   $events[] = $eventArray;
	}

	echo json_encode($events);
*/
if ($_GET['med'] <> '') {
    $login = $_GET['med'];

    $rReprox = $db->prepare("SELECT nom,ape,hc_paciente.dni,hc_reprod.med,des_dia,f_iny,h_iny,f_asp FROM hc_reprod,hc_paciente WHERE hc_paciente.dni=hc_reprod.dni and hc_reprod.med=? and (hc_reprod.p_od='' or hc_reprod.p_od IS NULL) and hc_reprod.f_asp<>'' ORDER BY hc_reprod.id DESC LIMIT 200");
    $rReprox->execute(array($login));

    $rReproTra = $db->prepare("SELECT nom,ape,hc_paciente.dni,hc_reprod.med,f_tra,h_tra FROM hc_reprod,hc_paciente WHERE hc_paciente.dni=hc_reprod.dni and hc_reprod.med=? and hc_reprod.h_tra<>'' ORDER BY hc_reprod.id DESC LIMIT 200");
    $rReproTra->execute(array($login));

    $rInter_Gine = $db->prepare("SELECT nom,ape,hc_paciente.dni,hc_gineco.med,in_t,in_f2,in_h2,in_m2 FROM hc_gineco,hc_paciente WHERE hc_paciente.dni=hc_gineco.dni and hc_gineco.med=? and hc_gineco.in_h2<>'' and hc_gineco.in_m2<>'' and hc_gineco.in_c=1 ORDER BY hc_gineco.id DESC LIMIT 200");
    $rInter_Gine->execute(array($login));

} else {
    $login = $_SESSION['login'];

    $rReprox = $db->prepare("SELECT nom,ape,hc_paciente.dni,hc_reprod.med,des_dia,f_iny,h_iny,f_asp FROM hc_reprod,hc_paciente WHERE hc_paciente.dni=hc_reprod.dni and (hc_reprod.p_od='' or hc_reprod.p_od IS NULL) and hc_reprod.f_asp<>'' ORDER BY hc_reprod.id DESC LIMIT 200");
    $rReprox->execute();

    $rReproTra = $db->prepare("SELECT nom,ape,hc_paciente.dni,hc_reprod.med,f_tra,h_tra FROM hc_reprod,hc_paciente WHERE hc_paciente.dni=hc_reprod.dni and hc_reprod.h_tra<>'' ORDER BY hc_reprod.id DESC LIMIT 200");
    $rReproTra->execute();

    $rInter_Gine = $db->prepare("SELECT nom,ape,hc_paciente.dni,hc_gineco.med,in_t,in_f2,in_h2,in_m2 FROM hc_gineco,hc_paciente WHERE hc_paciente.dni=hc_gineco.dni and hc_gineco.in_h2<>'' and hc_gineco.in_m2<>'' and hc_gineco.in_c=1 ORDER BY hc_gineco.id DESC LIMIT 200");
    $rInter_Gine->execute();

    $rInter_Uro = $db->prepare("SELECT p_nom,p_ape,hc_pareja.p_dni,hc_urolo.med,in_t,in_f2,in_h2,in_m2 FROM hc_urolo,hc_pareja WHERE hc_pareja.p_dni=hc_urolo.p_dni and hc_urolo.in_h2<>'' and hc_urolo.in_m2<>'' ORDER BY hc_urolo.id DESC LIMIT 200");
    $rInter_Uro->execute();
}

$rUser = $db->prepare("SELECT role FROM usuario WHERE user=?");
$rUser->execute(array($login));
$user = $rUser->fetch(PDO::FETCH_ASSOC);

if ($login <> "lab") {
    if ($user['role']==1 or  $user['role']==8) {
        $rObstex = $db->prepare("SELECT nom,ape,hc_paciente.dni,in_t,in_f2,in_h2,in_m2,con_fec,con_fec_h,con_fec_m FROM hc_obste,hc_paciente WHERE hc_paciente.dni=hc_obste.dni AND hc_obste.med=? AND hc_obste.con_fec_h<>'' AND hc_obste.con_fec_h<>'||||||||||||' ORDER BY hc_obste.id DESC LIMIT 200");
        $rObstex->execute(array($login));

        $rGinex = $db->prepare("SELECT nom,ape,hc_paciente.dni,hc_gineco.fec,fec_h,fec_m,in_c,in_t,in_f2,in_h2,in_m2,cupon FROM hc_gineco,hc_paciente WHERE hc_paciente.dni=hc_gineco.dni AND hc_gineco.med=? AND hc_gineco.fec_h<>'' AND hc_gineco.in_c<>1 ORDER BY hc_gineco.id DESC LIMIT 200");
        $rGinex->execute(array($login));
    }
    $rDisponi = $db->prepare("SELECT * FROM hc_disponible WHERE med=? ORDER BY fec DESC LIMIT 200");
    $rDisponi->execute(array($login));
}
$json = '[';
if ($login <> "lab") {
    if ($user['role']==1 or  $user['role']==8) {
        while ($cita = $rGinex->fetch(PDO::FETCH_ASSOC)) {
            $cupon = '';
            if ($cita['cupon'] == 1) $cupon = '(ConoNORTE)';
            if ($cita['cupon'] == 2) $cupon = '(ConoSUR)';
            $json = $json . '{"title":"(Ginecología) \n' . $cita['ape'] . ' ' . $cita['nom'] . '\n' . $cupon . '","start":"' . $cita['fec'] . 'T' . $cita['fec_h'] . ':' . $cita['fec_m'] . '","color":"green","url":"n_gine.php?id=' . $cita['dni'] . '"},';

            if ($cita['in_h2'] <> '' and $cita['in_c'] == 2) {
                $json = $json . '{"title":"(Intervención) \n' . $cita['ape'] . ' ' . $cita['nom'] . '\n' . $cita['in_t'] . '","start":"' . $cita['in_f2'] . 'T' . $cita['in_h2'] . ':' . $cita['in_m2'] . '","color":"orange","url":"n_gine.php?id=' . $cita['dni'] . '"},';
            }

        }

        while ($cita = $rObstex->fetch(PDO::FETCH_ASSOC)) {

            $con_fec = explode("|", $cita['con_fec']);
            $con_fec_h = explode("|", $cita['con_fec_h']);
            $con_fec_m = explode("|", $cita['con_fec_m']);

            for ($i = 0; $i < 16; $i++) {

                if ($con_fec[$i] <> '' and $con_fec_h[$i] <> '' and $con_fec_m[$i] <> '') {
                    $json = $json . '{"title":"(Obstetricia)\n' . $cita['ape'] . ' ' . $cita['nom'] . '","start":"' . $con_fec[$i] . 'T' . $con_fec_h[$i] . ':' . $con_fec_m[$i] . '","color":"green","url":"n_obst.php?id=' . $cita['dni'] . '"},';
                }
            }

            if ($cita['in_h2'] <> '') {

                $json = $json . '{"title":"(Intervención)\n' . $cita['ape'] . ' ' . $cita['nom'] . '\n' . $cita['in_t'] . '","start":"' . $cita['in_f2'] . 'T' . $cita['in_h2'] . ':' . $cita['in_m2'] . '","color":"orange","url":"n_obst.php?id=' . $cita['dni'] . '"},';
            }

        }
    }

    while ($dispo = $rDisponi->fetch(PDO::FETCH_ASSOC)) {

        $json = $json . '{"title":" - '.$dispo['fin'].'\n'.$dispo['obs'].'","start":"' .$dispo['fec'].'T'.$dispo['ini'].'","color":"deeppink"},';

    }
}

while ($cita = $rReprox->fetch(PDO::FETCH_ASSOC)) {

    if (is_null($cita['des_dia']))
        $json = $json . '{"title":"Aspiración\n' . $cita['ape'] . ' ' . $cita['nom'] . '\n (' . $cita['med'] . ')","start":"' . $cita['f_asp'] . '","url":"n_repro.php?id=' . $cita['dni'] . '"},';
    else {
        if ($cita['h_iny'] <> '')
            $json = $json . '{"title":"Descongelación\n' . $cita['ape'] . ' ' . $cita['nom'] . '\n (' . $cita['med'] . ')","start":"' . $cita['f_iny'] . 'T' . $cita['h_iny'] . '","url":"n_repro.php?id=' . $cita['dni'] . '"},';
    }
}

while ($cita = $rReproTra->fetch(PDO::FETCH_ASSOC)) {

    $json = $json . '{"title":"Transferencia\n' . $cita['ape'] . ' ' . $cita['nom'] . '\n (' . $cita['med'] . ')","start":"' . $cita['f_tra'] . 'T' . $cita['h_tra'] . '","url":"n_repro.php?id=' . $cita['dni'] . '"},';
}

while ($cita = $rInter_Gine->fetch(PDO::FETCH_ASSOC)) {

    $json = $json . '{"title":"' . $cita['in_t'] . ' \n' . $cita['ape'] . ' ' . $cita['nom'] . '\n (' . $cita['med'] . ')","start":"' . $cita['in_f2'] . 'T' . $cita['in_h2'] . ':' . $cita['in_m2'] . '","color":"green","url":"n_gine.php?id=' . $cita['dni'] . '"},';

}

if ($_GET['med'] == '') {
while ($cita = $rInter_Uro->fetch(PDO::FETCH_ASSOC)) {

    $json = $json . '{"title":"' . $cita['in_t'] . ' \n' . $cita['p_ape'] . ' ' . $cita['p_nom'] . '\n (' . $cita['med'] . ')","start":"' . $cita['in_f2'] . 'T' . $cita['in_h2'] . ':' . $cita['in_m2'] . '"},';

}}

$json = $json . '{"title":"nulo","start":"2000-01-12T07:00"}]';

$jsonxxx = '[{"title":"Meeting","start":"2015-01-12T07:00"},
  {
    "title":"Lunches \n juana maribel cubana delamarrana",
    "start":"2015-01-13T12:00"
  },
  {
    "title": "Meeting",
    "start": "2015-01-18T15:00",
	"color": "green"
  },{}]';
$input_arrays = json_decode($json, true);

// Accumulate an output array of event data arrays.
$output_arrays = array();
foreach ($input_arrays as $array) {

    // Convert the input array into a useful Event object
    $event = new Event($array, $timezone);

    // If the event is in-bounds, add it to the output
    if ($event->isWithinDayRange($range_start, $range_end)) {
        $output_arrays[] = $event->toArray();
    }
}

// Send JSON to the client.
echo json_encode($output_arrays);