<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260224125725 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX uniq_c7440455e7927c74 ON customer');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_81398E09E7927C74 ON customer (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX uniq_81398e09e7927c74 ON customer');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C7440455E7927C74 ON customer (email)');
    }
}
