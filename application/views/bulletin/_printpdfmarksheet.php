<div style="width: 100%; margin: 0 auto; border: 1px solid #000; padding: 0px 5px 5px">
    <!-- Header with school and student info -->
    <table cellpadding="0" cellspacing="0" width="100%" style="border-bottom: 2px solid black; margin-bottom: 15px;">
        <tr>
            <td valign="top" width="50%">
                <strong>RÉPUBLIQUE DU NIGER</strong><br>
                <?php echo $setting->address ?><br>
            </td>
            <td valign="top" width="50%" align="center">
                <strong><?php echo $setting->name ?></strong><br>
                DISCIPLINE - TRAVAIL - RÉUSSITE<br>
                <?php echo $setting->phone ?>

            </td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <strong>Année Scolaire:</strong> <?php echo $session['session'] ?> | <strong>Classe:</strong> <?php echo $student['class'].' '.$student['section'] ?> | <strong>Effectif:</strong> <?php echo $total_students; ?>
            </td>
        </tr>
    </table>

    <!-- Student Information -->
    <table width="100%" style="margin-bottom: 15px;">
        <tr>
            <td><strong>Matricule:</strong> <?php echo $student['id']; ?></td>
            <td><strong>Nom et Prénom:</strong> <?php echo $student['firstname'] . ' ' . $student['lastname']; ?></td>
            <td><strong>Rang:</strong> <?php echo $rank; ?></td>
        </tr>
    </table>

    <!-- Marks Table -->
    <table class="marks" cellspacing="0" cellpadding="5" style="border-collapse: collapse; width: 100%;">
        <thead>
        <tr>
            <th style="border: 1px solid black;">Disciplines</th>
            <th style="border: 1px solid black;">Coeff</th>
            <th style="border: 1px solid black;">Moy. Classe</th>
            <th style="border: 1px solid black;">Note Compo</th>
            <th style="border: 1px solid black;">Moy/20</th>
            <th style="border: 1px solid black;">Moy. Coeff</th>
            <th style="border: 1px solid black;">Appréciation</th>
            <th style="border: 1px solid black;">Signature</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $total = 0;
        $totalcoef = 0;
        foreach ($results as $result) {
            // Si la matière est "Conduite", toutes les valeurs doivent être la même
            if ($result['subject'] === 'Conduite') {
                $moyenne_classe = $conduite_note;
                $note_compo = $conduite_note;
                $moyenne = $conduite_note;
            } else {
                $moyenne_classe = $result['moyenne_classe'];
                $note_compo = $result['note_compo'];
                $moyenne = $result['moyenne_ponderee'];
            }

            $total += $moyenne * $result['coeficient'];
            $totalcoef += $result['coeficient'];
            ?>
            <tr>
                <td style="border: 1px solid black;"><?php echo $result['subject']; ?></td>
                <td style="border: 1px solid black;"><?php echo $result['coeficient']; ?></td>
                <td style="border: 1px solid black;"><?php echo $moyenne_classe; ?></td>
                <td style="border: 1px solid black;"><?php echo $note_compo; ?></td>
                <td style="border: 1px solid black;"><?php echo $moyenne; ?></td>
                <td style="border: 1px solid black;"><?php echo $moyenne * $result['coeficient']; ?></td>
                <td style="border: 1px solid black;">
                    <?php
                    if ($moyenne >= 18) {
                        echo "Excellent";
                    } elseif ($moyenne >= 16) {
                        echo "Très bien";
                    } elseif ($moyenne >= 14) {
                        echo "Bien";
                    } elseif ($moyenne >= 12) {
                        echo "Assez bien";
                    } elseif ($moyenne >= 10) {
                        echo "Passable";
                    } elseif ($moyenne >= 5) {
                        echo "Médiocre";
                    } elseif ($moyenne >= 2) {
                        echo "Null";
                    } else {
                        echo "Insuffisant";
                    }
                    ?>
                </td>
                <td style="border: 1px solid black;"></td>
            </tr>
        <?php } ?>
        <tr>
            <td style="border: 1px solid black; font-weight: bold;">Total</td>
            <td style="border: 1px solid black; font-weight: bold;"><?php echo $totalcoef; ?></td>
            <td colspan="3" style="border-bottom: 1px solid black;"></td>
            <td style="border: 1px solid black; font-weight: bold;"><?php echo $total; ?></td>
            <td colspan="2" style="border-bottom: 1px solid black;"></td>
        </tr>
        </tbody>
    </table>


    <!-- Moyenne Table -->
    <div style="margin-top: 15px;">
        <table width="100%" style="border: 1px solid black; border-collapse: collapse;">
            <tr>
                <td style="text-align:center;border: 1px solid black;"><strong>Moyenne Semestrielle sur 20:</strong> <?php echo sprintf('%.2f', $total/$totalcoef) ; ?></td>
            </tr>
        </table>
    </div>

    <?php
    // Calculer la moyenne générale de l'élève
    $moyenne_generale = $total / $totalcoef;  // Par exemple

    // Déterminer les valeurs dynamiques en fonction de la moyenne générale
    $conduite = ($conduite_note >= 15) ? "Très Bonne" : (($conduite_note >= 10) ? "Bonne" : "Médiocre");
    $travail = ($moyenne_generale >= 15) ? "Excellent" : (($moyenne_generale >= 10) ? "Moyen" : "Nul");
    $tableau_honneur = ($moyenne_generale >= 16) ? "Oui" : "Non";
    $assiduite = ($moyenne_generale >= 12) ? "Oui" : "Non";  // Exemple d'assiduité basée sur la moyenne
    $retard = ($moyenne_generale < 8) ? "Oui" : "Non";  // Retard si la moyenne est très basse
    $resultat_fin_annee = ($moyenne_generale >= 10) ? "Passe" : "Redouble";

    ?>

    <!-- Remarks Section -->
    <div style="margin-top: 10px;">
        <table width="100%" style="border: 1px solid black; border-collapse: collapse;">
            <tr>
                <td style="text-align:center;border: 1px solid black;"><strong>Conduite:</strong> <?php echo $conduite; ?></td>
                <td style="text-align:center;border: 1px solid black;"><strong>Travail:</strong> <?php echo $travail; ?></td>
                <td style="text-align:center;border: 1px solid black;"><strong>Tableau d'Honneur:</strong> <?php echo $tableau_honneur; ?></td>
                <td style="text-align:center;border: 1px solid black;"><strong>Assiduité:</strong> <?php echo $assiduite; ?></td>
                <td style="text-align:center;border: 1px solid black;"><strong>Retard:</strong> <?php echo $retard; ?></td>
            </tr>
        </table>
    </div>

    <!-- Footer -->
    <div style="margin-top: 20px;">
        <table width="100%">
            <tr>
                <td><strong>Résultat de fin d'année:</strong> <?php echo $resultat_fin_annee; ?></td>
                <td><strong>Visa des Parents:</strong></td>
            </tr>
        </table>
        <div style="text-align: right; margin-top: 30px;">
            <strong>Le Proviseur</strong><br>
            (Signature et cachet)
        </div>
    </div>

</div>
