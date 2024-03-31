<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240310220808 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->connection->insert('product', ['name' => 'Iphone', 'price' => 10000]);
        $this->connection->insert('product', ['name' => 'Наушники', 'price' => 2000]);
        $this->connection->insert('product', ['name' => 'Чехол', 'price' => 1000]);
        $this->connection->insert('product', ['name' => 'Автомобиль', 'price' => 10000000]);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
