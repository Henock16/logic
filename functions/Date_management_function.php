<?php

	date_default_timezone_set('UTC');
	setlocale(LC_TIME, 'fr', 'fr_FR', 'fr_FR.ISO8859-1');
	
    function getHolidays($year = null){
		
        if ($year === null){
			
			$year = intval(strftime('%Y'));
        }
    
        $easterDate = easter_date($year);
        $easterDay = date('j', $easterDate);
        $easterMonth = date('n', $easterDate);
        $easterYear = date('Y', $easterDate);
    
        $holidays = array(
		
			// Jours feries fixes
			mktime(0, 0, 0, 1, 1, $year),// 1er janvier
			mktime(0, 0, 0, 5, 1, $year),// Fete du travail
			//mktime(0, 0, 0, 5, 8, $year),// Victoire des allies
			mktime(0, 0, 0, 8, 7, $year),// Fete nationale
			mktime(0, 0, 0, 8, 15, $year),// Assomption
			mktime(0, 0, 0, 11, 1, $year),// Toussaint
			//mktime(0, 0, 0, 11, 11, $year),// Armistice
			mktime(0, 0, 0, 12, 25, $year),// Noel

			// Jour feries qui dependent de paques
			mktime(0, 0, 0, $easterMonth, $easterDay + 1, $easterYear),// Lundi de paques
			mktime(0, 0, 0, $easterMonth, $easterDay + 39, $easterYear),// Ascension
			mktime(0, 0, 0, $easterMonth, $easterDay + 50, $easterYear), // Pentecote
        );
    
        sort($holidays);
        return $holidays;
    }
    
    function diffCalendar($firstDate, $secondDate){
		
        $oFirstDate = new DateTime($firstDate);
        $oSecondDate = new DateTime($secondDate);

        return (integer) ($oSecondDate->getTimestamp() - $oFirstDate->getTimestamp());
    }
    
    function diffWorkDay($firstDate, $secondDate){
        /*
         * Pour calculer le nombre de jours ouvres,
         * on calcule le nombre total de jours et
         * on soustrait les jours fériés et les week end.
         */
        $iDiffCalendar = diffCalendar($firstDate, $secondDate);

        $oFirstDate = new DateTime($firstDate);
        $oSecondDate = new DateTime($secondDate);

        $iFirstYear = $oFirstDate->format('Y');
        $iSecondYear = $oSecondDate->format('Y');

        $aHolidays = array();

        /*
         * Si l'interval demande chevauche plusieurs annees
         * on doit avoir les jours feries de toutes ces annees
         */
        for($iYear = $iFirstYear; $iYear <= $iSecondYear; $iYear++){
			
			$aHolidays = array_merge(getHolidays($iYear), $aHolidays);
        }

        /*
         * On est oblige de convertir les timestamps en string a cause des decalages horaires.
         */
        $aHolidaysString = array_map(function ($value){
			
            return strftime('%Y-%m-%d', $value);
        }, $aHolidays);

        for ($i = $oFirstDate->getTimestamp(); $i < $oSecondDate->getTimestamp(); $i += 86400){
			
			/* Numero du jour de la semaine, de 1 pour lundi a 7 pour dimanche */
			$iDayNum = strftime('%u', $i);

			if (in_array(strftime('%Y-%m-%d', $i), $aHolidaysString) OR $iDayNum == 6 OR $iDayNum == 7){
				
				/* Si c'est ferie ou samedi ou dimanche, on soustrait le nombre de secondes dans une journee. */
				$iDiffCalendar -= 86400;
			}
        }

        return (integer) $iDiffCalendar;
    }
    
    function calculDiff($datetime, $date){
		
        $dateformat = date_format($datetime, 'Y-m-d');
        $workhour = ((diffWorkDay($dateformat, $date) / 86400) - 1)*8;
        return $worhour;
    }
    
    function calHourDep($datetime){
        
        $mydate = new DateTime($datetime);
        $time = date('H:i:s', strtotime($datetime));
        $tabl = explode(":",$time);
        
        if($tabl[0] < 8){
			
            $hour = 8;
            $min = 0;
            $sec = 0;
        }
        elseif($tabl[0] >= 17){
			
            $hour = 0;
            $min = 0;
            $sec = 0;
        }
        else{
			
            $hour = 16 - $tabl[0];
            $min = 59 - $tabl[1];
            $sec = 60 - $tabl[2];
        }
        
        $hourdep[0] = $hour;
        $hourdep[1] = $min;
        $hourdep[2] = $sec;
        
        return $hourdep;
    }
    
    function calHourFin($datetime){
        
        $mydate = new DateTime($datetime);
        $time = date('H:i:s', strtotime($datetime));
        $tabl = explode(":",$time);
        
        if($tabl[0] < 8){
			
            $hour = 0;
            $min = 0;
            $sec = 0;
        }
        elseif($tabl[0] >= 17){
			
            $hour = 8;
            $min = 0;
            $sec = 0;
        }
        else{
			
            $hour = $tabl[0] - 8;
            $min = $tabl[1];
            $sec = $tabl[2];
        }
        
        $hourfin[0] = $hour;
        $hourfin[1] = $min;
        $hourfin[2] = $sec;
        
        return $hourfin;
    }
    
    function diffHour($datetime1, $datetime2){
		
        $time1 = date('H:i:s', strtotime($datetime1));
        $time2 = date('H:i:s', strtotime($datetime2));
        
        $tab1 = explode(":",$time1);
        $tab2 = explode(":",$time2);
        
        $tab[0] = $tab2[0] - $tab1[0];
        $tab[1] = $tab2[1] + (59 - $tab1[1]);
        $tab[2] = $tab2[2] + (59 - $tab1[2]);
        
        return $tab;
    }
    //Test des fonctions
    /*echo ((diffWorkDay('2018-02-20', '2018-02-21') / 86400)-1)*8;
    echo "</br>";
    echo calHourDep('2017-06-05 09:45:18')[0];
    echo "</br>";
    echo calHourDep('2017-06-05 09:45:18')[1];
    echo "</br>";
    echo calHourDep('2017-06-05 09:45:18')[2];
    echo "</br>";
    echo calHourFin('2017-06-12 15:36:53')[0];
    echo "</br>";
    echo calHourFin('2017-06-12 15:36:53')[1];
    echo "</br>";
    echo calHourFin('2017-06-12 15:36:53')[2];*/
?>