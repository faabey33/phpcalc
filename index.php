<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Rechner</title>
    </head>
    <body>
        <?php
        
        $index = 0;

        if (isset($_POST["term"]) == true) {                                    //checkt input
            $eingabe = $_POST["term"];                                          //eingabe wird als variable gespeichert

            echo $eingabe . '<br><br>';                                          

            $zahlen = split('[*/+-]', $eingabe);                                //teilt die eingabe überall wo ein *,+,-,/ ist und schreibt die stücke in das array zahlen
            
            $zeichen = split('[0123456789]', $eingabe);                         //teilt die eingabe überall wo zahlen sind und schreibt so die rechenzeichen in das array zeichen
            $zeichen = array_diff($zeichen, array(''));                         //löscht die lücken zwischen den zeichen
            $zeichen = array_slice($zeichen, 0);                                //löscht die leeren lücken ganz raus und rückt die einträge auf

            $count = count($zahlen);                                            //zählt die anzahl der einträge vom array zahlen
            while ($index < $count) {                                           //solange index < anzahl der zahlen
                echo $index . ' Zahl: ' . $zahlen[$index] . '<br>';             //wird die zahl und deren position ausgegeben
                $index++;                                                       //erhöht index um 1
            }

            echo '<br>';

            $index = 0;                                                         //index wird wieder auf 0 gesetzt
            $count = count($zeichen);                                           //zählt jetzt die anzahl der einträge im array zeichen
            while ($index < $count) {                                           
                echo $index . ' Zeichen: ' . $zeichen[$index] . '<br>';         //gibt alle zeichen mit der position im array aus
                $index++;
            }

            echo '<br><br>';

            while ((in_array("*", $zeichen)) || (in_array("/", $zeichen))) {    //wenn ein * oder ein / in der Rechnung ist wird das ausgeführt (punkt vor strich)

                $mp = array_search('*', $zeichen);                              //sucht die position von dem ersten *    (falls vorhanden)                                              
                $div = array_search('/', $zeichen);                             //sucht die position von dem ersten /    (falls vorhanden)

                if ((in_array("*", $zeichen)) && (in_array("/", $zeichen))) {   //wenn beides im Term ist, dann wird von links nach rechts gerechnet

                    if ($div < $mp) {                                           //d.h. wenn / zuerst kommt, dann
                        $zahlen[$div] = $zahlen[$div] / $zahlen[($div + 1)];    //zahl vor dem / geteilt durch zahl nach dem /
                        $zahlen[$div + 1] = '';                                 //die alte zahl löschen
                        $zeichen[$div] = '';                                    //das / löschen
                    } else {
                        $zahlen[$mp] = $zahlen[$mp] * $zahlen[($mp + 1)];       //sonst, wenn * vor / kommt, dann
                        $zahlen[$mp + 1] = '';                                  //zahl vor dem * multipliziert mit zahl nach dem *
                        $zeichen[$mp] = '';                                     //wieder alte zahl und * löschen
                    }
                } elseif (in_array("*", $zeichen)) {                            //wenn nur ein * gefunden wird, wird nur die multiplikation durchgeführt
                    $zahlen[$mp] = $zahlen[$mp] * $zahlen[($mp + 1)];
                    $zahlen[$mp + 1] = '';
                    $zeichen[$mp] = '';
                } elseif (in_array("/", $zeichen)) {                            //oder bei / nur die Division
                    $zahlen[$div] = $zahlen[$div] / $zahlen[($div + 1)];
                    $zahlen[$div + 1] = '';
                    $zeichen[$div] = '';
                }

                
                $zeichen = array_diff($zeichen, array(''));                     //die leeren einträge loschen und lücken füllen
                $zeichen = array_slice($zeichen, 0);
                $zahlen = array_diff($zahlen, array(''));
                $zahlen = array_slice($zahlen, 0);
                
                $index = 0;                                                     //index wieder 0
                $count = count($zahlen);                                        //hier werden wieder alle zahlen und zeichen ausgegeben
                while ($index < $count) {
                    echo $index . ' Zahl: ' . $zahlen[$index] . '<br>';
                    $index++;
                }
                echo '<br>';

                $index = 0;
                $count = count($zeichen);
                while ($index < $count) {
                    echo $index . ' Zeichen: ' . $zeichen[$index] . '<br>';
                    $index++;
                }

               

                echo '<br><br>';
            }


            while ((in_array("-", $zeichen)) || (in_array("+", $zeichen))) {    //sind keine * oder / mehr vorhanden wird geprüft ob es + oder - gibt

                $plus = array_search('+', $zeichen);                            //position von + und - in je eine variable
                $minus = array_search('-', $zeichen);


                if ((in_array("+", $zeichen)) && (in_array("-", $zeichen))) {   //wenn beide vorkommen, wird wieder von links nach rechts gerechnet
                                                                                //auch wenn man das eigentlich nicht bräuchte, aber so funktionert es

                    if ($plus < $minus) {
                        $zahlen[$plus] = $zahlen[$plus] + $zahlen[$plus + 1];
                        $zahlen[$plus + 1] = '';
                        $zeichen[$plus] = '';
                    } else {
                        $zahlen[$minus] = $zahlen[$minus] - $zahlen[$minus + 1];
                        $zahlen[$minus + 1] = '';
                        $zeichen[$minus] = '';
                    }
                } elseif ((in_array("+", $zeichen))) {                          //nurnoch ein +, dann nur die addition

                    $zahlen[$plus] = $zahlen[$plus] + $zahlen[$plus + 1];
                    echo '<br>';
                    $zahlen[$plus + 1] = '';
                    $zeichen[$plus] = '';
                } elseif ((in_array("-", $zeichen))) {                          //ein -, nur noch die subtraktion

                    $zahlen[$minus] = $zahlen[$minus] - $zahlen[$minus + 1];
                    echo '<br>';
                    $zahlen[$minus + 1] = '';
                    $zeichen[$minus] = '';
                }

                $zeichen = array_diff($zeichen, array(''));                     //lücken füllen
                $zeichen = array_slice($zeichen, 0);
                $zahlen = array_diff($zahlen, array(''));
                $zahlen = array_slice($zahlen, 0);
            }


            echo 'Ergebnis: ' . $zahlen[0];                                     //am ende bleibt dann noch der 0. eintrag von dem array zahlen übrig - das ergebnis
        } else {
            echo 'Eingabe: ';
        }


        
        ?>


        <form action="index.php" method="post">
            <input type="text" name="term">
            <br><br>
            <input type="submit" value="Rechnen!">
        </form>

    </body>
</html>
