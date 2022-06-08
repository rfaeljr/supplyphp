<?php include('../Controle/includes.php') ?>

<div class="row">            
    <nav>
        <div class="nav-wrapper">
            <a href="#" class="brand-logo"><img src="Resources/img/logo-brk-branco-62.png" class="logotipo"/></a>
            <ul class="right hide-on-med-and-down">
                <li>
                    <a class="dropdown-button" href="#!" data-activates="solicitacao">Solicitação
                        <i class="material-icons right">arrow_drop_down</i>
                    </a>
                    <!-- Dropdown Structure -->
                    <ul id="solicitacao" class="dropdown-content">
                        <?php 
                           if(Funcoes::acessa( 'notamov.php' ) == 'y'){
                              echo("<li><a href='notamov.php'>Nota de Movimentação</a></li>");
                           }
                        ?>
                        <li class="divider"></li>
                        <?php 
                           if(Funcoes::acessa( 'docmat.php' ) == 'y'){
                              echo("<li><a href='docmat.php'>Doc Mat</a></li>");
                           }
                        ?>

                    </ul>
                </li>
                
                <li><a href="relatorios.php">Relatórios</a></li>
                
                
                <!-- Dropdown Trigger -->
                <li>
                    <a class="dropdown-button" href="#!" data-activates="administracao">Administração
                        <i class="material-icons right">arrow_drop_down</i>
                    </a>
                    <!-- Dropdown Structure -->
                    <ul id="administracao" class="dropdown-content">
                        <li class="divider"></li>
                        <?php
                        if(Funcoes::acessa( 'seguranca.php' ) == 'y'){
                              echo("<li><a href='seguranca.php'>Permissões</a></li>");
                        }
                        ?>

                        <li class="divider"></li>
                        <?php
                        if(Funcoes::acessa( 'ue.php' ) == 'y'){
                              echo("<li><a href='ue.php'>Cadastro de UE's</a></li>");
                        }
                        ?>

                        <?php
                        if(Funcoes::acessa( 'ua.php' ) == 'y'){
                              echo("<li><a href='ua.php'>Cadastro de UA's</a></li>");
                        }
                        ?>

                        <?php
                        if(Funcoes::acessa( 'material.php' ) == 'y'){
                              echo("<li><a href='material.php'>Cadastro de Materiais</a></li>");
                        }
                        ?>
                    </ul>
                </li>
                <li class="tooltipped" data-tooltip="Logoff">
                    <a href="logoff.php"><img height="20px;"src="./Resources/img/logoff.png"/> </a>
                </li>
            </ul>
        </div>
    </nav>            
</div>