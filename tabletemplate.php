<?php 

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
  <!-- With actions -->
  <h4 class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300">
    <?php echo $t["titulo"] ?>
  </h4>
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
        $i2 = $t["itensPorPag"]*$t["numDaPag"];
        $i1 = $i2-$t["itensPorPag"]+1;
        if($i2 > $t["qtdDeLinhas"]) $i2 = $t["qtdDeLinhas"];
        echo "Mostrando $i1-$i2 de $t[qtdDeLinhas]<br>";
        ?>
      </span>
      <span class="col-span-2"></span>
      <!-- Pagination -->
      
      
      <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
        <nav aria-label="Table navigation">
          <ul class="inline-flex items-center">
            <li>
              <button class="px-3 py-1 rounded-md rounded-l-lg focus:outline-none focus:shadow-outline-verdecoopaf" aria-label="Previous">
                <svg class="w-4 h-4 fill-current" aria-hidden="true" viewBox="0 0 20 20"><path d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" fill-rule="evenodd"></path></svg>
              </button>
            </li>
            
            <?php
            $numDePags = intval(ceil($t["qtdDeLinhas"]/$t["itensPorPag"]));
            // echo $numDePags;

            $numMaxDeBot = 7;
            $numMinDeBotNoFinal = 2;
            ?>
            <li>
              <button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-verdecoopaf">
                1
              </button>
            </li>
            <li>
              <span class="px-3 py-1">...</span>
            </li>
            <li>
              <button class="px-3 py-1 rounded-md rounded-r-lg focus:outline-none focus:shadow-outline-verdecoopaf" aria-label="Next">
                <svg class="w-4 h-4 fill-current" aria-hidden="true" viewBox="0 0 20 20"><path d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" fill-rule="evenodd"></path></svg>
              </button>
            </li>
          </ul>
        </nav>
      </span>
    </div>
    <?php } ?>
  </div>
<?php

}

?>

