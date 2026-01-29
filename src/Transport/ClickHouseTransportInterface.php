<?php
declare(strict_types=1);

namespace DenyWhite\ClickLink\Transport;

use DenyWhite\ClickLink\Protocol\ClickHouseRequest;
use DenyWhite\ClickLink\Protocol\ClickHouseResponse;
use DenyWhite\ClickLink\Transport\Exception\ClickHouseTransportException;

interface ClickHouseTransportInterface
{
    /**
     * Отправляет SQL-запрос на сервер ClickHouse и возвращает сырой ответ.
     *
     * Этот метод реализует конкретный протокол (например, HTTP),
     * но не занимается парсингом ClickHouse-формата.
     *
     * @throws ClickHouseTransportException   При ошибках сети, таймаутах, недоступности хоста
     */
    public function send(ClickHouseRequest $request): ClickHouseResponse;
}