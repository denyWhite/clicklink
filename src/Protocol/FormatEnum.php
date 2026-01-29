<?php
declare(strict_types=1);

namespace DenyWhite\ClickLink\Protocol;

enum FormatEnum: string
{
    /** Табуляция между значениями (по умолчанию в HTTP-интерфейсе). */
    case TabSeparated = 'TabSeparated';

    /** Comma-Separated Values */
    case CSV = 'CSV';

    /** CSV с заголовками колонок. */
    case CSVWithNames = 'CSVWithNames';

    /** CSV с заголовками и типами данных. */
    case CSVWithNamesAndTypes = 'CSVWithNamesAndTypes';

    /** Табуляция с заголовками колонок. */
    case TabSeparatedWithNames = 'TabSeparatedWithNames';

    /** Табуляция с заголовками и типами данных. */
    case TabSeparatedWithNamesAndTypes = 'TabSeparatedWithNamesAndTypes';

    /** Альтернативное название для TabSeparated. */
    case TSV = 'TSV';

    /**  Читаемый формат для человека. */
    case Pretty = 'Pretty';

    /** Компактный читаемый формат. */
    case PrettyCompact = 'PrettyCompact';

    /** Читаемый формат с разделением пробелами. */
    case PrettySpace = 'PrettySpace';

    /** Вывод в виде вертикальных пар "имя-значение". */
    case Vertical = 'Vertical';

    /** Только значения без заголовков. */
    case Values = 'Values';

    /** Формат для отображения в Markdown. */
    case Markdown = 'Markdown';

    /** Extensible Markup Language. */
    case XML = 'XML';

    /** Json */
    case JSON = 'JSON';

    /** Каждая строка в отдельном JSON-объекте. */
    case JSONEachRow = 'JSONEachRow';

    /** Компактный вариант JSONEachRow с обратным порядком. */
    case JSONCompactEachRow = 'JSONCompactEachRow';

    /** Компактный массив JSON-объектов. */
    case JSONCompact = 'JSONCompact';

    /** Компактный JSONEachRow с именами и типами данных. */
    case JSONCompactEachRowWithNamesAndTypes = 'JSONCompactEachRowWithNamesAndTypes';

    /** Собственный бинарный формат ClickHouse. */
    case Native = 'Native';

    /** Строковый бинарный формат. */
    case RowBinary = 'RowBinary';

    /** Google Protocol Buffers. */
    case Protobuf = 'Protobuf';

    /** MessagePack. */
    case MsgPack = 'MsgPack';

    /** Optimized Row Columnar. */
    case ORC = 'ORC';

    /** Колонковый формат данных. */
    case Parquet = 'Parquet';

    /** Apache Avro. */
    case Avro = 'Avro';

    /** Apache Arrow. */
    case Arrow = 'Arrow';

    /** NumPy. */
    case Npy = 'Npy';

    /** ODBC Driver 2. */
    case ODBCDriver2 = 'ODBCDriver2';

    /** Формат для Prometheus. */
    case Prometheus = 'Prometheus';

    /** Пользовательский формат на основе шаблонов. */
    case Template = 'Template';

    /** Сырые бинарные данные. */
    case RawBLOB = 'RawBLOB';

    /** Пустой формат. */
    case Null = 'Null';

    /** Регулярные выражения. */
    case Regexp = 'Regexp';
}
