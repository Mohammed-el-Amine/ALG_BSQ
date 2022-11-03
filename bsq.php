<?php


/**
 * functions utile a l'algo
 * bigSquare =>
 * secondTableau =>
 * verif => 
 * afficherGrandSquare =>
 * finale => 
 */
function bigSquare($array, $rowLength)
{
    $rowIndex = 0;
    $bigSquarePos = array();
    $x = null;
    $y = null;
    $maxNum = 0;

    foreach ($array as $row) {
        for ($i = 0; $i < $rowLength; $i++) {
            
            $topLeft = isset($array[$rowIndex - 1][$i - 1]) ? intval($array[$rowIndex - 1][$i - 1]) : 0;
            $top = isset($array[$rowIndex - 1][$i]) ? intval($array[$rowIndex - 1][$i]) : 0;
            $left = isset($array[$rowIndex][$i - 1]) ? intval($array[$rowIndex][$i - 1]) : 0;
            
            $array[$rowIndex][$i] = verif(intval($row[$i]), $topLeft, $top, $left);
            
            if ($maxNum < $array[$rowIndex][$i]) {
                $maxNum = $array[$rowIndex][$i];
                $x = $i;
                $y = $rowIndex;
            }
        }
        $rowIndex++; 
    }
    return ['size' => $maxNum, "x" => $x, "y" => $y];
}
function secondTableau($array, $rowLength)
{
    $newArr = array();

    foreach ($array as $row) {
        for ($i = 0; $i < $rowLength; $i++) {
            if ($row[$i] == "." ) {
                $row[$i] = '1';
            } else {
                $row[$i] = '0';
            }
        }
        $newArr[] = $row;
    }
    return $newArr;
}

function verif($cell, $topLeft = 0, $top = 0, $left = 0)
{
    if($cell !=0){
        return  min([$topLeft, $top, $left]) + $cell;
    }
    return 0;
}

function afficheGrandSqare($board, $data)
{
    $size = $data['size'];
    $x = $data['x'];
    $y = $data['y'];
    
    for ($i = 0; $i < $size; $i++) { 
        for ($j = 0; $j < $size; $j++) { 
            $board[$y - $i][$x - $j] = 'x'; 
        }
    }

    foreach ($board as $row) {
        echo "$row\n";
    }

}


/**
 * function executant l'algo
 */
function finale($contentFile)
{
    $nombreDeLignes = "";

    $board = array();

    $handle = @fopen($contentFile, 'r');
    if ($handle) {
        
        $nombreDeLignes = intval(fgets($handle));
        
        while ($line = fgets($handle)) {
            $board[] = trim($line);
        }

        $rowLength = strlen($board[0]);
        $board2 = secondTableau($board, $rowLength);
        
        $data = bigSquare($board2, $rowLength);
        
        afficheGrandSqare($board, $data);
    }
    fclose($handle);
}

/**
 * execution du fichier uniquement si l'on ajoute un fichier supplementaire contenant le board originale
 */
if ($argc === 2){
    
    finale($argv[1]);

}
else echo "Err ajouter le paramètre : fichier à lire \nex => php bsq.php example_file \n";