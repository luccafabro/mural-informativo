<?php

class Artigo
{
    private $mysql;

    public function __construct(mysqli $mysql)
    {
        $this->mysql = $mysql;
    }

    public function exibirTodos(): array
    {

        $resultado = $this->mysql->query('SELECT id, titulo, conteudo FROM artigos');

        $artigos = $resultado->fetch_all(MYSQLI_ASSOC);

        return $artigos;
    }

    public function encontrarPorID(string $id): array
    {
        // Preparando a função
        $selecionaArtigo = $this->mysql->prepare("SELECT id, titulo, conteudo FROM artigos WHERE id = ?");
        // Passando o tipo do parametro e o valor
        $selecionaArtigo->bind_param('s', $id);
        // Executando a função
        $selecionaArtigo->execute();
        // Pegando o resultado do artigo e deixando em array
        $artigo = $selecionaArtigo->get_result()->fetch_assoc();
        return $artigo;
    }

    public function adicionar(string $titulo, string $conteudo): void
    {
        $insereArtigo = $this->mysql->prepare('INSERT INTO artigos (titulo, conteudo) VALUES(?,?);');
        $insereArtigo->bind_param('ss', $titulo, $conteudo);
        $insereArtigo->execute();
    }

    public function editar(string $id, string $titulo, string $conteudo): void
    {
        $editaArtigo = $this->mysql->prepare('UPDATE artigos SET titulo = ?, conteudo = ? WHERE id = ?');
        $editaArtigo->bind_param('sss', $titulo, $conteudo, $id);
        $editaArtigo->execute();
    }

    public function excluir(string $id): void
    {
        $excluiArtigo = $this->mysql->prepare('DELETE FROM artigos WHERE id = ?');
        $excluiArtigo->bind_param('s', $id);
        $excluiArtigo->execute();
    }
}
