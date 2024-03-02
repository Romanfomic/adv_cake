<?php

function revertCharacters($str) {
    // Разбиваем строку на слова
    $words = preg_split('/(\s+)/u', $str, -1, PREG_SPLIT_DELIM_CAPTURE);

    $result = '';
    foreach ($words as $word) {
        // Разбиваем слово на символы
        $characters = preg_split('//u', $word, -1, PREG_SPLIT_NO_EMPTY);

        // Определяем пунктуацию
        $punctuation = preg_replace('/[^\p{P}]/u', '', $word);

        // Удаляем пунктуацию из слова
        $word = preg_replace('/[\p{P}]/u', '', $word);

        // Меняем порядок букв в слове
        $reversedWord = implode('', array_reverse($characters));

        // Восстанавливаем пунктуацию
        $reversedWord .= $punctuation;

        // Сохраняем регистр первой буквы
        if (mb_strtoupper($word[0], 'UTF-8') === $word[0]) {
            $reversedWord = mb_strtoupper($reversedWord, 'UTF-8');
        } elseif (mb_strtolower($word[0], 'UTF-8') === $word[0]) {
            $reversedWord = mb_strtolower($reversedWord, 'UTF-8');
        }
        $result .= $reversedWord;
    }

    return $result;
}

// Unit-тесты
function testRevertCharacters() {
    $input1 = "Привет! Давно не виделись.";
    $expected1 = "Тевирп! Онвад ен ьсиледив.";
    print_r(revertCharacters($input1) === $expected1);

    $input2 = "Hello, World!";
    $expected2 = "Olleh, Dlrow!";
    print_r(revertCharacters($input2) === $expected2);

    $input3 = "Abcde.";
    $expected3 = "Edcba.";
    print_r(revertCharacters($input3) === $expected3);

    echo "All tests passed successfully!";
}

// Запуск тестов
testRevertCharacters();
