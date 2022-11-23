<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendrier & Evènements</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi"
      crossorigin="anonymous"/>
      <link rel="stylesheet" href="calendar.css">
</head>
<body>

<nav class="navbar navbar-dark bg-primary mb-3">
    <a href="/index.php" class="navbar-brand">Mon calendrier</a>
</nav>

<?php 
use Vtiful\Kernel\Format;
require '../src/date/month.php';
try{
    $month = new App\date\Month($_GET['month'] ?? null, $_GET['year'] ?? null);
    $start = $month->getStartingDay();
    $start = $start->format('N') === '1' ? $start : $month->getStartingDay()->modify('Last Monday');
} catch (\Exception $e){
    $month = new \App\date\Month();
} ?>

<div class="d-flex flex-row align-items-center justify-content-between mx-3">
    <h1><?= $month->toString(); ?></h1>
    <div>
        <a href="/index.php?month=<?= $month->previousMonth()->month; ?>&year=<?= $month->previousMonth()->year; ?>" class="btn btn-primary"><</a>
        <a href="/index.php?month=<?= $month->nextMonth()->month; ?>&year=<?= $month->nextMonth()->year; ?>" class="btn btn-primary">></a>
    </div>

</div>


<table class="calendar__table calendar__table--<?= $month->getWeeks();?>weeks">
    <?php for ($i = 0; $i < $month->getWeeks(); $i++): ?>

        <tr>
            <?php
            foreach ($month->days as $k => $day):
                $date = (clone $start)->modify("+" . ($k + $i * 7) . " days");
            ?>
            <td class="<?= $month->withinMonth($date) ? '' : 'calendar__othermonth'; ?>">
                <?php if ($i === 0): ?>
                <div class="calendar__weekday"><?= $day; ?></div>
                <?php endif; ?>
                <div class="calendar__day"><?= $date->format('d'); ?></div>
            </td>            
            <?php endforeach; ?>
        </tr>

    <?php endfor; ?>
</table>

</body>
</html>