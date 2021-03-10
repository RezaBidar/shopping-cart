<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210309150140 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE `order` AUTO_INCREMENT = 10000');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE `order` AUTO_INCREMENT = 1');
    }
}
