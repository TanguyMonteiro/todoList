<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210723093541 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `check` (id INT AUTO_INCREMENT NOT NULL, todo_id INT NOT NULL, user_id INT NOT NULL, UNIQUE INDEX UNIQ_3C8EAC13EA1EBC33 (todo_id), INDEX IDX_3C8EAC13A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `check` ADD CONSTRAINT FK_3C8EAC13EA1EBC33 FOREIGN KEY (todo_id) REFERENCES todo (id)');
        $this->addSql('ALTER TABLE `check` ADD CONSTRAINT FK_3C8EAC13A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE `check`');
    }
}
