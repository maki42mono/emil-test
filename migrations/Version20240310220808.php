<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use App\Entity\Product;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

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
        $this->connection->insert('product', ['name' => 'Iphone', 'price' => 100]);
        $this->connection->insert('product', ['name' => 'Наушники', 'price' => 20]);
        $this->connection->insert('product', ['name' => 'Чехол', 'price' => 10]);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
