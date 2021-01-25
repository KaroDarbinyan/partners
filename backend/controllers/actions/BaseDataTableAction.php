<?php

namespace backend\controllers\actions;

use nullref\datatable\DataTableAction;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;

class BaseDataTableAction extends DataTableAction
{
    public function init()
    {
        if ($this->query === null) {
            throw new InvalidConfigException(get_class($this) . '::$query must be set.');
        }

        if ($this->formatData === null) {
            $this->formatData = function ($query, $columns) {
                $rows = [];
                foreach ($query->all() as $obj) {
                    $row = [];
                    foreach ($columns as $column) {
                        if ($column['data']) {

                            $value = ArrayHelper::getValue($obj, $column['data'], null);

                            if (($pos = strrpos($column['data'], '.')) !== false) {

                                $keys = explode('.', $column['data']);
                                $a = $value;
                                foreach (array_reverse($keys) as $key) {
                                    $a = [$key => $a];
                                }

                                if (key_exists($keys[0], $row)) {
                                    $row[$keys[0]] = array_merge($row[$keys[0]], $a[$keys[0]]);
                                } else {
                                    $row[$keys[0]] = $a[$keys[0]];
                                }
                            } else {
                                $row[$column['data']] = $value;
                            }
                        }
                    }
                    $rows[] = $row;
                }

                return $rows;
            };
        }
    }

    /**
     * Get a start and end date.
     *
     * @param $value
     *
     * @return array
     *
     * @throws \Exception
     */
    public function getDateRange($value)
    {
        list ($start, $end) = explode(' - ', $value);

        $start = $this->getDateTimeFromString($start);
        $start->setTime(0, 0, 0);
        $start = $start->format('U');

        $end = $this->getDateTimeFromString($end);
        $end->setTime(23, 59, 59);
        $end = $end->format('U');

        return compact('start', 'end');
    }

    /**
     * Convert the string date to DateTime.
     *
     * @param $value
     *
     * @return \DateTime
     *
     * @throws \Exception
     */
    public function getDateTimeFromString($value)
    {
        return new \DateTime($value, new \DateTimeZone('Europe/Oslo'));
    }
}