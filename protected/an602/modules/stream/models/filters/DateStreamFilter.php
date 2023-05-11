<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2022 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 *
 */

namespace an602\modules\stream\models\filters;

use DateTime;
use DateTimeZone;
use Yii;
use yii\helpers\FormatConverter;

/**
 * Class DateStreamFilter
 * @package an602\modules\stream\models\filters
 *
 * @property-read string $dateFrom
 * @property-read string $dateTo
 */
class DateStreamFilter extends StreamQueryFilter
{
    const CATEGORY_FROM = 'date_filter_from';
    const CATEGORY_TO = 'date_filter_to';

    /**
     * Created from date
     * @var string
     */
    public $date_filter_from;

    /**
     * Created to date
     * @var string
     */
    public $date_filter_to;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date_filter_from', 'date_filter_to'], 'safe'],
            ['date_filter_from', 'validateDateFrom']
        ];
    }

    public function validateDateFrom()
    {
        if ($this->isFilteredFrom() && $this->isFilteredTo() && $this->dateFrom > $this->dateTo) {
            $this->addError(self::CATEGORY_FROM, Yii::t('StreamModule.base','Date "From" should be before "To"!'));
        }
    }

    public function apply()
    {
        if ($this->isFilteredFrom()) {
            $this->query->andWhere(['>=', 'content.created_at', $this->dateFrom . ' 00:00:00']);
        }

        if ($this->isFilteredTo()) {
            $this->query->andWhere(['<=', 'content.created_at', $this->dateTo . ' 23:59:59']);
        }
    }

    private function formatDateToMysql(string $date): string
    {
        $localeDateFormat = FormatConverter::convertDateIcuToPhp(Yii::$app->formatter->dateInputFormat);
        $timeZone = new DateTimeZone(Yii::$app->formatter->timeZone);
        $dateTime = DateTime::createFromFormat($localeDateFormat, $date, $timeZone);
        $mysqlDateFormat = 'Y-m-d';

        return $dateTime ? $dateTime->format($mysqlDateFormat) : date($mysqlDateFormat);
    }

    private function isFilteredFrom(): bool
    {
        return !empty($this->date_filter_from);
    }

    private function isFilteredTo(): bool
    {
        return !empty($this->date_filter_to);
    }

    public function getDateFrom(): string
    {
        return $this->formatDateToMysql($this->date_filter_from);
    }

    public function getDateTo(): string
    {
        return $this->formatDateToMysql($this->date_filter_to);
    }
}
