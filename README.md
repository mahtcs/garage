# Garage - Sistema de Gestão de Vagas de Garagem

Desenvolvi o `Garage`  como um projeto de portfólio para praticar e registrar meu aprendizado de Laravel. 

O sistema simula uma plataforma onde usuários podem alugar vagas de garagem ociosas de outros usuários para estacionar seus veículos.

-----------------------------------------------------------------------------------------------------------------------------
## Stack Utilizada

A escolha das tecnologias foi focada em produtividade e ferramentas modernas.

* **Livewire (v3)**: Para criar a interface dinâmica. Com ele, pude construir componentes reativos (como modais e formulários que se atualizam sozinhos)
* **Jetstream**: Para acelerar o início. É um starter kit do Laravel que já me entregou todo o sistema de login, registro e perfil de usuário pronto e seguro.
* **Tailwind CSS**: Para a estilização. Um framework CSS que permite criar o design direto no HTML com classes utilitárias, o que torna a estilização muito mais rápida.
* **Docker & Laravel Sail**: Para o ambiente de desenvolvimento. Com um único comando (`sail up`), todo o ambiente necessário (PHP, MySQL, etc.) sobe dentro de contêineres, garantindo que o projeto rode em qualquer máquina sem dor de cabeça.

-----------------------------------------------------------------------------------------------------------------------------

##  Pré-requisitos

Antes de começar, garanta que você tenha as seguintes ferramentas instaladas e configuradas:

* **WSL2 (Subsistema do Windows para Linux)** com uma distribuição Ubuntu.
* **Docker Desktop** configurado para usar o backend do WSL2.
* **Git** instalado no seu ambiente WSL.

##  Como Rodar o Projeto (Passo a Passo)

Siga os passos abaixo para executar a aplicação em seu ambiente local.

**1. Clonar o Repositório**
Abra seu terminal WSL (Ubuntu) e clone este repositório para o diretório de sua preferência.

```bash
git clone [https://github.com/mahtcs/garage.git](https://github.com/mahtcs/garage.git)
cd garage
```

**2. Copiar o Arquivo de Ambiente**

```bash
cp .env.example .env
```

**3. Instalar as Dependências do Composer**

```bash
docker run --rm \
    -v "$(pwd)":/opt \
    -w /opt \
    laravelsail/php83-composer:latest \
    composer install
```

**4. Subir os Contêineres com o Sail**

```bash
bash ./vendor/bin/sail up -d
```

**5. Gerar a Chave da Aplicação**

```bash
bash ./vendor/bin/sail php artisan key:generate
```

**6. Rodar as Migrations e Seeders**

```bash
bash ./vendor/bin/sail php artisan migrate --seed
```

**7. Compilar os Assets de Front-end**

```bash
bash ./vendor/bin/sail npm install
bash ./vendor/bin/sail npm run dev
```

**8. Pronto!**
A aplicação agora está rodando! Você pode acessá-la em seu navegador no seguinte endereço:

[**http://localhost**](http://localhost)

---

##  Solução de Problemas (Troubleshooting)

Durante a instalação em ambientes WSL, podem ocorrer alguns problemas de permissão. Se você encontrar algum erro, aqui estão as soluções mais comuns:

### Erro de Permissão ao Rodar Comandos `artisan` ou `sail`

**Sintoma:** O terminal exibe uma mensagem como `Permission denied` ao tentar executar um comando `php artisan` ou ao tentar escrever em arquivos de log (`storage/logs`).

**Causa:** Os arquivos do projeto podem ter sido criados com o usuário `root` do contêiner Docker, e seu usuário do WSL não tem permissão para modificá-los.

**Solução:** Execute o seguinte comando na raiz do projeto para tornar seu usuário o dono de todos os arquivos e pastas.

```bash
sudo chown -R $USER:$USER .
```

### Erro `Permission denied` ao Executar `./vendor/bin/sail`

**Sintoma:** Ao tentar executar `./vendor/bin/sail up`, o terminal retorna `Permission denied`, mesmo após ajustar o dono dos arquivos.

**Causa:** O sistema de arquivos do WSL pode estar montado de uma forma que impede a execução direta de scripts.

**Solução:** Execute o script `sail` usando o `bash` diretamente neste formato:

```bash
# Formato correto
bash ./vendor/bin/sail up -d

# Em vez de:
# ./vendor/bin/sail up -d
```

---
