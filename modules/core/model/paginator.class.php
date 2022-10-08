<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\core\model\paginator.class.php   \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Este modelo incluye lo relacionado a la paginación
 *
 *
*/

class Paginator
{
    
	/**
     * getPages($total, $limit)
     * 
     * @description Información extra de paginación
	*/
	function getPages($total, $limit, $section = ''){
		//
		$pages['total'] = ceil($total / $limit);
		// PAGINA
		$page = isset($_GET['page']) && ctype_digit($_GET['page']) && strpos(Core::$sSection, $section) !== false ? $_GET['page'] : 1;
		// PAGINA ACTUAL
		$pages['current'] = (float)$page;
        // NÚMERO DE PÁGINAS
		$pages['pages'] = $pages['total'];
        // ANTERIOR
		$pages['prev'] = $page > 2 ? $page - 1 : 0;
        // SIGUIENTE
		$pages['next'] = $page < $pages['total'] ? ($pages['current'] + 1) : $pages['current'];
        // TOTAL de RESULTADOS
        $pages['results'] = $total;
        // LIMITE DB
        $pages['limit'] = (($page - 1) * $limit).','.$limit;
		// RETORNAMOS
		return $pages;
	}
    
    /**/
	// Constructs a page list.
	// $pageindex = constructPageIndex($scripturl . '?board=' . $board, $_REQUEST['start'], $num_messages, $maxindex, true);
	function pageIndex($base, $max_value, $num_per_page, $flexible_start = false)
    {
        // INFORMACIÓN DE PÁGINAS
        $pages = $this->getPages($max_value, $num_per_page, $base[1]);
        $pages['total'] = $pages['total'] == '0' ? $pages['total'] + 1 : $pages['total'];
        
        // Definir URL de Base
        /*$base_url = explode('&page=',$base_url);
        $base_url = $base_url[0];
        $base['section'] = Core::$sSection;*/
        $base[2] = isset($base[2]) ? $base[2] : null;
        $base[3] = isset($base[3]) ? $base[3] : null;
        $base[4] = isset($base[4]) && is_array($base[4]) ? $base[4] : null;
        $base_url = Core::model('extra', 'core')->generateUrl($base[0], $base[1], $base[2], $base[3], $base[4]);
        
        // Código del OnClick
        $pages['onclick'] = $this->getOnclick($base);
        
        // REDIRIGE SI LA PÁGINA INTRODUCIDA ES MÁS GRANDE DE LO PERMITIDO
        if($pages['current'] > $pages['total'] || (isset($_GET['page']) && $_GET['page'] == '0'))
        {
            Core::model('extra', 'core')->redirectTo($base_url . '&page=' . $pages['total']);
        }
        
        // Página actual
        $start = $pages['current'];
        
        // PÁGINA ACTUAL POR CANTIDAD DE RESULTADOS POR PÁGINA
        $start = $start * $num_per_page;
        
				// Save whether $start was less than 0 or not.
				$start_invalid = $start < 0;

				// Make sure $start is a proper variable - not less than 0.
				if ($start_invalid)
					$start = 0;
				// Not greater than the upper bound.
				elseif ($start >= $max_value)
					$start = max(0, (int) $max_value - (((int) $max_value % (int) $num_per_page) == 0 ? $num_per_page : ((int) $max_value % (int) $num_per_page)));
				// And it has to be a multiple of $num_per_page!
				else $start = max(0, (int) $start - ((int) $start % (int) $num_per_page));

		    $base_link = '<li class="waves-effect"><a href="' . ($flexible_start ? $base_url : ($base_url . '&page={page}"') ) . ' onclick="'.str_replace('{page_n}', '{page}', $pages['onclick']).'">{page}</a></li>';

				// If they didn't enter an odd value, pretend they did.
				$PageContiguous = (int) (5 - (5 % 2)) / 2;

				// Show the first page. (>1< ... 6 7 [8] 9 10 ... 15)
				if ($start > ($num_per_page * 3) && $start > $num_per_page * $PageContiguous)
					$pageindex = str_replace('{page}', '1', $base_link);
				else
					$pageindex = '';

				// Show the ... after the first page.  (1 >...< 6 7 [8] 9 10 ... 15)
				if ($start > ($num_per_page * 3) && $start > $num_per_page * ($PageContiguous))
					$pageindex .= '<li class="disabled"><a href="#">...</a></li>';

				// Show the pages before the current one. (1 ... >6 7< [8] 9 10 ... 15)
				for ($nCont = $PageContiguous; $nCont >= 1; $nCont--)
					if ($start >= $num_per_page * $nCont)
				{
				$tmpStart = $start - $num_per_page * $nCont;
                    if($tmpStart > 0) $pageindex.= str_replace('{page}', $tmpStart / $num_per_page, $base_link);
				}
	
				// Show the current page. (1 ... 6 7 >[8]< 9 10 ... 15)
            
				if (!$start_invalid && $pages['current'] == ($start / $num_per_page))
					$pageindex .= '<li class="active"><a href="#">' . ($start / $num_per_page) . '</a></li> ';
				else
					 if($start / $num_per_page > 0) $pageindex .= str_replace('{page}', $start / $num_per_page, $base_link);

				// Show the pages after the current one... (1 ... 6 7 [8] >9 10< ... 15)
				$tmpMaxPages = (int) (($max_value - 1) / $num_per_page) * $num_per_page;

				for ($nCont = 1; $nCont <= $PageContiguous; $nCont++)
					if ($start + $num_per_page * $nCont <= $tmpMaxPages)
					{
						$tmpStart = $start + $num_per_page * $nCont;
						$pageindex .= str_replace('{page}', $tmpStart / $num_per_page, $base_link);
					}
	
					// Show the '...' part near the end. (1 ... 6 7 [8] 9 10 >...< 15)
					if ($start + $num_per_page * ($PageContiguous + 1) < $tmpMaxPages)
						$pageindex .= '<li class="disabled"><a href="#">...</a></li>';

					// Show the last number in the list. (1 ... 6 7 [8] 9 10 ... >15<)
					if ($start + $num_per_page * $PageContiguous < $tmpMaxPages)
						$pageindex .= str_replace('{page}', $tmpMaxPages / $num_per_page, $base_link);


		            // LATERALES sin definir
		            $pages['left'] = '';
		            $pages['right'] = $pages['current'] == $pages['total'] ? '<li class="active"><a href="#">' . $pages['total'] . '</a></li>' : str_replace('{page}', $pages['total'], $base_link);

		            // Laterales izquierdos
		            if($pages['prev'] > 1)
		            {
		                $pages['left'] = '<li class="waves-effect"><a href="' . $base_url . '&page=1" onclick="'.str_replace('{page_n}', '1', $pages['onclick']).'"><i class="material-icons">first_page</i></a></li>
		                                  <li><a href="' . $base_url . '&page='. $pages['prev'] .'" onclick="'.str_replace('{page_n}', $pages['prev'], $pages['onclick']).'"><i class="material-icons">chevron_left</i></a></li>';
            }
            
            // laterales derechos
            if($pages['next'] < $pages['total'])
            {
                $pages['right'] .= '<li class="waves-effect"><a href="' . $base_url . '&page=' . $pages['next'] . '" onclick="'.str_replace('{page_n}', $pages['next'], $pages['onclick']).'"><i class="material-icons">chevron_right</i></a></li>
                                   <li class="waves-effect"><a href="' . $base_url . '&page=' . $pages['total'] .'" onclick="'.str_replace('{page_n}', $pages['total'], $pages['onclick']).'"><i class="material-icons">last_page</i></a></li>';
            }
            
            // Paginador HTML
            $pages['paginator'] = '<div class="center-align"><ul class="pagination">'.$pages['left'].$pageindex.$pages['right'].'</ul></div>';
	
			return $pages;
		}
    
    function getOnclick($base = array())
    {
        
        if($base[0] == 'admin')
        {
        	$base[2] = isset($base[2]) ? $base[2] : '';
        	$base[3] = isset($base[3]['search']) ? $base[3]['search'] : '';
            $onclick = 'admin.forms.page(\'' . substr(ucfirst($base[1]), 0, -1) . '\', \'{page_n}\', \'' . $base[2] . '\', \'' . $base[3] . '\'); return false;';
        }
        elseif($base[0] == 'mod')
        {
            $base[2] = isset($base[2]) ? $base[2] : '';
            $base[3] = isset($base[3]['search']) ? $base[3]['search'] : '';
            $onclick = 'mod.forms.page(\'' . substr(ucfirst($base[1]), 0, -1) . '\', \'{page_n}\', \'' . $base[2] . '\', \'' . $base[3] . '\'); return false;';
        }
        elseif($base[1] == 'messages')
        {
            if($base[2] == 'view')
            {
                $onclick = 'messages.conversation.page(\'' . $base['hash'] . '\', \''.$base[3]['id'].'\', \'{page_n}\'); return false;';
            }
            else
            {
                $onclick = 'messages.forms.page(\'' . substr(ucfirst($base[2]), 0, -1) . '\', \'{page_n}\'); return false;';
            }
        }
        else
        {
        	$onclick = '';
        }
        
        return $onclick;
    }
}
