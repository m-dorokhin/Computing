<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 02.04.19
 * Time: 22:24
 */

namespace App;

/**
 * Class CodeSearcher
 * Класс для поиска кодов в рассчёте
 * @package App
 */
class CodeSearcher
{
    private const SEARCH = 'search';
    private const EXTRACT = 'extract';

    private $numbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

    private $cods = [];
    private $buffer = '';
    private $state = self::SEARCH;
    private $computing = '';

    /**
     * CodeSearcher constructor.
     * @param $computing
     */
    public function __construct($computing)
    {
        $this->computing = $computing;

        for ($i = 0; $i < strlen($computing); $i++)
        {
            $symbol = $computing[$i];
            if ($this->state == self::EXTRACT)
            {
                if (($symbol == '+' or $symbol == '-') and $this->buffer == '')
                {
                    $this->add_symbol($symbol);
                }
                elseif (in_array($symbol, $this->numbers))
                {
                    $this->add_symbol($symbol);
                }
                elseif ($symbol == '}')
                {
                    $this->end_extraction();
                }
                else
                {
                    $this->stop_extraction();
                }
            }
            elseif ($symbol == '{') {
                $this->start_extraction();
            }
        }
    }

    /**
     * Вернуть найденные коды
     *
     * @return array
     */
    public function get_cods()
    {
        return $this->cods;
    }

    /**
     * Начать извлечение кода
     */
    private function start_extraction()
    {
        $this->buffer = '';
        $this->state = self::EXTRACT;
    }

    /**
     * Добавить символ к коду
     *
     * @param $symbol
     */
    private function add_symbol($symbol)
    {
        $this->buffer = $this->buffer.$symbol;
    }

    /**
     * Остановить извлечение кода и обнулить буфер
     */
    private function stop_extraction()
    {
        $this->buffer = '';
        $this->state = self::SEARCH;
    }

    /**
     * Законыить извлечение кода и сохранить содержимое буффера
     */
    private function end_extraction()
    {
        $this->cods[] = (int) $this->buffer;
        $this->buffer = '';
        $this->state = self::SEARCH;
    }
}