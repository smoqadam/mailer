<?php

namespace App\Mail\Contracts;

interface Mailable
{
    public function setEmail(string $email);

    public function getEmail(): string;

    public function setName(string $name);

    public function getName(): string;

    public function getSubject(): string;

    public function setSubject(string $subject);

    public function getBody(): string;

    public function setBody(string $body);

    public function isHtml(): bool;

    public function setIsHtml(bool $isHtml);

    public function toArray(): array;
}
