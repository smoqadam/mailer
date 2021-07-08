<?php

namespace App\Mail;

trait MailableTrait
{
    private string $subject;
    private string $body;
    private bool $isHtml;
    private string $email;
    private string $name;

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): void
    {
        $this->subject = $subject;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function setBody(string $body): void
    {
        $this->body = $body;
    }

    public function isHtml(): bool
    {
        return $this->isHtml;
    }

    public function setIsHtml(bool $isHtml): void
    {
        $this->isHtml = $isHtml;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
}
