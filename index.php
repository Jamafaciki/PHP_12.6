<?php
$example_persons_array = [
    [
        'fullname' => 'Иванов Иван Иванович',
        'job' => 'tester',
    ],
    [
        'fullname' => 'Степанова Наталья Степановна',
        'job' => 'frontend-developer',
    ],
    [
        'fullname' => 'Пащенко Владимир Александрович',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Громов Александр Иванович',
        'job' => 'fullstack-developer',
    ],
    [
        'fullname' => 'Славин Семён Сергеевич',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Цой Владимир Антонович',
        'job' => 'frontend-developer',
    ],
    [
        'fullname' => 'Быстрая Юлия Сергеевна',
        'job' => 'PR-manager',
    ],
    [
        'fullname' => 'Шматко Антонина Сергеевна',
        'job' => 'HR-manager',
    ],
    [
        'fullname' => 'аль-Хорезми Мухаммад ибн-Муса',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Бардо Жаклин Фёдоровна',
        'job' => 'android-developer',
    ],
    [
        'fullname' => 'Шварцнегер Арнольд Густавович',
        'job' => 'babysitter',
    ],
];


function  getPartsFromFullname($fullname){
    $template = explode(' ', $fullname);
    return ['surname' => $template[0],'name' => $template[1],'patronomyc' => $template[2]];
}

function  getFullnameFromParts($lastname ,$name ,$patronomyc){
    return $lastname . ' ' . $name . ' ' . $patronomyc;
}

function getShortName($fullname){
    $template = getPartsFromFullname($fullname);
    $surname = $template['surname'];
    $firstWordsurname = mb_substr($surname, 0, 1);
    
    return $template['name'] . ' ' . $firstWordsurname . '.';
}

function getGenderFromName($fullname){
    $template = getPartsFromFullname($fullname);
    $genderSign = 0;
    $lenItem = mb_strlen($template['patronomyc']);

    if(mb_substr($template['patronomyc'],$lenItem - 3, 3) == 'вна'){
        $genderSign--;
    } else if(mb_substr($template['patronomyc'],$lenItem - 2, 2) == 'ич'){
        $genderSign++;
        }

    $lenItem = mb_strlen($template['name']);

    if(mb_substr($template['name'],$lenItem - 1, 1) == 'а'){
        $genderSign--;
    } else if(mb_substr($template['name'],$lenItem - 1, 1) == 'й' || mb_substr($template['name'],$lenItem - 1, 1) == 'н' ){
        $genderSign++;
        }

    $lenItem = mb_strlen($template['surname']);

    if(mb_substr($template['surname'],$lenItem - 2, 2) == 'ва'){
        $genderSign--;
    } else if(mb_substr($template['surname'],$lenItem - 1, 1) == 'в'){
        $genderSign++;
    }

    $resault = $genderSign <=> 0;

    if($resault == 1){
        return 'Мужской пол';
    } else if($resault == -1){
        return 'Женский пол';
    } else if($resault == 0){
        return 'Неопределенный пол';
    }
}

function getGenderDescription($example_persons_array){
    $countHumans = count($example_persons_array);
    $header = 'Гендерный состав аудитории:' . '<br>' . '---------------------------' . '<br>' ;
    $arrMale = array_filter($example_persons_array, function($val) {
        return getGenderFromName($val['fullname']) == 'Мужской пол';
    });
    $arrFemale = array_filter($example_persons_array, function($val) {
        return getGenderFromName($val['fullname']) == 'Женский пол';
    });
    $arrUndefinedgender = array_filter($example_persons_array, function($val) {
        return getGenderFromName($val['fullname']) == 'Неопределенный пол';
    }); 

    $MaleCount = count($arrMale);
    $FemaleCount = count($arrFemale);
    $UndefinedgenderCount = count($arrUndefinedgender);

    $statsMale = round($MaleCount / $countHumans * 100, 1);
    $statsFemale = round($FemaleCount / $countHumans * 100, 1);
    $statsUndefinedgender = round($UndefinedgenderCount / $countHumans * 100, 1);

    $resaultMale = 'Мужчины - ' . $statsMale . ' %' . '<br>';
    $resaultFemale = 'Женщины - ' . $statsFemale . ' %' . '<br>';
    $resaultUndefinedgender = 'Не удалось определить - ' . $statsUndefinedgender . '%' . '<br>';
    
    return $header . $resaultMale . $resaultFemale . $resaultUndefinedgender;
}

function getPerfectPartner($lastname ,$name ,$patronomyc, $example_persons_array){

    $lastname = mb_strtolower($lastname);
    $name = mb_strtolower($name);
    $patronomyc = mb_strtolower($patronomyc);

    $fullname = getFullnameFromParts($lastname ,$name ,$patronomyc);
    $fullname = mb_convert_case($fullname, MB_CASE_TITLE, "UTF-8");

    $identificationGender = getGenderFromName($fullname);
    
    $countArr = count($example_persons_array) - 1;

    $randomPerson = $example_persons_array[random_int(0, $countArr)]['fullname'];
    $GenderRandomPerson = getGenderFromName($randomPerson);

    while($identificationGender == $GenderRandomPerson){
        $randomPerson = $example_persons_array[random_int(0, $countArr)]['fullname'];
        $GenderRandomPerson = getGenderFromName($randomPerson);
        }

    $imputname = getShortName($fullname);
    $randomname = getShortName($randomPerson);

    $compatibility = mt_rand(5000, 10000)/100;

    $resault = $imputname . ' + ' . $randomname . ' = <br>' . '♡ Идеально на ' . $compatibility . '% ♡';

    return $resault;
}

echo 'Задача №1 - "Разбиение и объединение ФИО" <br><br> getPartsFromFullname: <br>';
print_r(getPartsFromFullname('Иванов Иван Иванович'));
echo '<br><br>' .'getFullnameFromParts: ';
print_r(getFullnameFromParts('Иванов' ,'Иван' ,'Иванович'));
echo '<br><br>';
echo 'Задача №2 - "Сокращение ФИО" <br><br> getShortName: <br> Иванов Иван Иванович -> ' . getShortName('Иванов Иван Иванович') . '<br><br>';
echo 'Задача №3 - "Функция определения пола по ФИО" <br><br> getGenderFromName:<br>Иванов Иван Иванович -> ' . getGenderFromName('Иванов Иван Иванович') . '<br>Степанова Наталья Степановна -> ' . getGenderFromName('Степанова Наталья Степановна') . '<br>Бардо Жаклин Фёдоровна -> ' . getGenderFromName('Бардо Жаклин Фёдоровна') . '<br><br>';
echo 'Задача №4 - "Определение возрастно-полового состава" <br><br> ' . getGenderDescription($example_persons_array) . '<br><br>';
echo 'Задача №5 - "Идеальный подбор пары" <br><br> Иванов Иван Иванович -><br> ' . getPerfectPartner('Иванов' ,'Иван' ,'Иванович',$example_persons_array);