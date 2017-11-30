<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Automobiliai</title>
</head>
<body>
<h1>12 Užduotis</h1>
<?php
/*#12 - Uždavinys - Padarykite formą įvesti automobilius
1) Greičio fiksavimo data ir laikas, pvz: 2016-12-31 23:15:25
2) Automobilio numeris, pvz: ABC 001
3) Nuvažiuotas atstumas metrais
4) Sugaištas laikas sekundėmis
Tegul programa atsimena (session arba cookie) visus suvestus automobilius ir,
žemiau įvedimo formos, išveda juos greičių mažėjimo tvarka į html lentelę.*/
?>

<h1>Automobiliai</h1>

    <form method="post" action="">
    <br><label>Greičio fiksavimo data ir laikas: </label><input type="text" name="date" required/></br>
    <br><label>Automobilio numeris, pvz: ABC 001: </label><input type="text" name="number" required/></br>
    <br><label>Nuvažiuotas atstumas metrais: </label><input type="number" name="distance" required/></br>
    <br><label>Sugaištas laikas sekundėmis: </label><input type="number" name="time" required/></br>
    <br> <button type="submit">Įvesti</button></br>
    <br></form>

<?php
class Radar {
    public $date;
    public $number;
    public $distance;
    public $time;
    function __construct($date, $number, $distance, $time) {
        $this->date = $date;
        $this->number = $number;
        $this->distance = $distance;
        $this->time = $time;
    }
    function greitisKmh() {
        $greitisMs = $this->distance/$this->time;
        $greitisKmh = $greitisMs*3.6;
        return round($greitisKmh,1);
    }
}
if (isset($_SESSION['radars'])) {
    $radars = $_SESSION['radars'];
    }  else $radars = [];

/*$radars = [;
    new Radar('2016-01-01 14:30:00', '1' , '5600', '300'),
    new Radar('2015-11-15 07:35:20', '2', '11000', '690'),
    new Radar('2017-01-21 11:20:10', '3', '15000', '1250'),
    new Radar('2017-01-21 07:10:11', '4', '100500', '4200')
];*/
if (isset($_REQUEST['date'])) {
    $radar = new Radar ($_REQUEST['date'], $_REQUEST['number'], $_REQUEST['distance'], $_REQUEST['time']);
    $radars[] = $radar;
    $_SESSION['radars'] = $radars;
}
usort($radars, function($a,$b) {
    $greitisA = $a ->greitisKmh();
    $greitisB = $b ->greitisKmh();
    return $greitisA == $greitisB? 0 : $greitisA < $greitisB ? 1 : -1;
});
?>

<table border="1">
<tr>
    <th>Automobilio numeris</th>
    <th>Data, laikas</th>
    <th>Atstumas, m </th>
    <th>Laikas, s </th>
    <th>Greitis Km/h</th>
</tr>
<?php foreach ($radars as $radar): ?>
<tr>
    <td><?php echo $radar->number ?></td>
    <td><?php echo $radar->date ?></td>
    <td><?php echo $radar->distance ?></td>
    <td><?php echo $radar->time ?></td>
    <td><?php echo $radar ->greitisKmh () ?></td>
</tr>
<?php endforeach; ?>
</table>

</body>
</html>
