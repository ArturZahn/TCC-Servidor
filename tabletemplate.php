<?php 

$posicaoBarra = strripos($_SERVER['PHP_SELF'], "/");
$url;
if($posicaoBarra == -1) $url = $_SERVER['PHP_SELF'];
else $url = substr($_SERVER['PHP_SELF'], $posicaoBarra+1);

$t;
function tabela($t)
{
  $GLOBALS["t"] = $t;
  function linhas()
  {
    $t = $GLOBALS["t"];
    
    
    while($exibe = mysqli_fetch_array($t["dados"]))
    {
      echo "<tr class='text-gray-700 dark:text-gray-400'>";
    
      foreach ($t["templateColunas"] as $templateColuna)
      {
        echo "<td class='px-4 py-3'>".$templateColuna($exibe)."</td>";
      }
  
      echo "</tr>";
    }
  }

  ?>
  
  <?php if(!empty($t["titulo"])) { ?>
  <h4 class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300">
    <?php echo $t["titulo"] ?>
  </h4>
  <?php } ?>
  <div class="w-full overflow-hidden rounded-lg shadow-xs">
    <div class="w-full overflow-x-auto">
      <table class="w-full whitespace-no-wrap">
        <thead>
          <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
              <?php
                  foreach ($t["nomeColunas"] as $keynomecolunas => $nomecolunas) {
                      # code...
                      echo "<th class='px-4 py-3'>$nomecolunas</th>";
                  }
              ?>
            
          </tr>
        </thead>
        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                <?php linhas(); ?>
        </tbody>
      </table>
    </div>

    <?php if($t["qtdDeLinhas"]>$t["itensPorPag"]) { ?>
    <div class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
      <span class="flex items-center col-span-3">
        <?php 
        $p2 = $t["itensPorPag"]*$t["numDaPag"];
        $p1 = $p2-$t["itensPorPag"]+1;
        if($p2 > $t["qtdDeLinhas"]) $p2 = $t["qtdDeLinhas"];
        echo "Mostrando $p1-$p2 de $t[qtdDeLinhas]<br>";
        ?>
      </span>
      <span class="col-span-2"></span>
      <!-- Pagination -->
      
      
      <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
        <nav aria-label="Table navigation">
          <ul class="inline-flex items-center">
            <!-- <li>
              <button class="px-3 py-1 rounded-md rounded-l-lg focus:outline-none focus:shadow-outline-verdecoopaf" aria-label="Previous">
                <svg class="w-4 h-4 fill-current" aria-hidden="true" viewBox="0 0 20 20"><path d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" fill-rule="evenodd"></path></svg>
              </button>
            </li> -->
            
            <?php
            $numMaxDeBot = 7;
            $numMinDeBotNasPonstas = 1;
            $numMaxDeBotDoLadoDoSelecionado = 2;

            $numDePags = intval(ceil($t["qtdDeLinhas"]/$t["itensPorPag"]));

            function botaoTresPontos() { return "<li><span class='px-3 py-1'>...</span></li>"; }
            function botao($str, $link, $estaMarcada) { return "<li><button class='px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-verdecoopaf".($estaMarcada?" text-white transition-colors duration-150 bg-verdecoopaf-600 border border-r-0 border-verdecoopaf-600":"")."' onclick='window.location=\"$link\"'>$str</button></li>";}

            // echo $numDePags;

            function linkParaPag($i)
            {
              $linkPrev = "$GLOBALS[url]?p=$i";

              foreach ($_GET as $key => $value)
              {
                if($key != "p") $linkPrev .= "&$key=$value";
              }

              return $linkPrev;
            }

            if($numDePags <= $numMaxDeBot)
            {
              for ($i=1; $i <= $numDePags; $i++) { 
                echo botao($i, linkParaPag($i), $i == $t["numDaPag"]);
              }
            }
            else
            {
              for ($i=1; $i <= $numMinDeBotNasPonstas; $i++) { 
                echo botao($i, linkParaPag($i), $i == $t["numDaPag"]);
              }

              
              $i1 = $t["numDaPag"]-$numMaxDeBotDoLadoDoSelecionado;
              if($i1 <= $numMinDeBotNasPonstas) $i1 = $numMinDeBotNasPonstas+1;
              
              $i2 = $t["numDaPag"]+$numMaxDeBotDoLadoDoSelecionado;
              if($i2 >= $numDePags-$numMinDeBotNasPonstas) $i2 = $numDePags-$numMinDeBotNasPonstas;

              $qtdDeBotoesPulados = $t["numDaPag"]-$numMinDeBotNasPonstas-$numMaxDeBotDoLadoDoSelecionado-1;
              if($qtdDeBotoesPulados > 1) echo botaoTresPontos();
              else if($qtdDeBotoesPulados == 1) echo botao($numMinDeBotNasPonstas+1, linkParaPag($numMinDeBotNasPonstas+1), false);
              
              for ($i=$i1; $i <= $i2; $i++) { 
                echo botao($i, linkParaPag($i), $i == $t["numDaPag"]);
              }
              
              $qtdDeBotoesPulados =  $numDePags-$t["numDaPag"]-$numMinDeBotNasPonstas-$numMaxDeBotDoLadoDoSelecionado;
              if($qtdDeBotoesPulados > 1) echo botaoTresPontos();
              else if($qtdDeBotoesPulados == 1) echo botao($numDePags-$numMinDeBotNasPonstas, linkParaPag($numDePags-$numMinDeBotNasPonstas), false);

              for ($i = $numDePags-$numMinDeBotNasPonstas+1; $i <= $numDePags; $i++) { 
                echo botao($i, linkParaPag($i), $i == $t["numDaPag"]);
              }
            }

            ?>
            <!-- <li>
              <button class="px-3 py-1 rounded-md rounded-r-lg focus:outline-none focus:shadow-outline-verdecoopaf" aria-label="Next">
                <svg class="w-4 h-4 fill-current" aria-hidden="true" viewBox="0 0 20 20"><path d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" fill-rule="evenodd"></path></svg>
              </button>
            </li> -->
          </ul>
        </nav>
      </span>
    </div>
    <?php } ?>
  </div>
<?php

}

?>

