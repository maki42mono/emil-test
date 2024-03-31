<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240331171717 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->connection->insert('discount', ['code' => 'XXX', 'type' => 1, 'value' => 1000]);
        $this->connection->insert('discount', ['code' => 'HAPPY', 'type' => 1, 'value' => 1500]);
        $this->connection->insert('discount', ['code' => 'HELLO', 'type' => 1, 'value' => 2000]);
        $this->connection->insert('discount', ['code' => 'GRANNY', 'type' => 1, 'value' => 3000]);
        $this->connection->insert('discount', ['code' => 'MAXIM', 'type' => 1, 'value' => 9000]);
        $this->connection->insert('discount', ['code' => 'AAA', 'type' => 2, 'value' => 100]);
        $this->connection->insert('discount', ['code' => 'SAD', 'type' => 2, 'value' => 199]);
        $this->connection->insert('discount', ['code' => 'RAIN', 'type' => 2, 'value' => 499]);
        $this->connection->insert('discount', ['code' => 'DOLLARS', 'type' => 2, 'value' => 10000]);
    }

    public function down(Schema $schema): void
    {
    }
}
