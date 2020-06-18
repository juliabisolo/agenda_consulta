<?php
    use PHPUnit\Framework\TestCase;
    class Tests extends TestCase
    {
        public function testCreateConsultas()
        {
            //deleta todas as consultas e insere uma. 1 = 1.
            $value = 1;
            
            TTransaction::open('agenda');

            $profissao = new Profissao();
            $profissao->descricao = 'Profissão teste auto.';
            $profissao->store();
            
            $pessoa = new Pessoa();
            $pessoa->nome = 'Ana Maria';
            $pessoa->cpf = date('048.353.090-57');
            $pessoa->dt_nascimento = ('1998-10-10');
            $pessoa->endereco = 'Rua Teste Auto';
            $pessoa->telefone = '(51)00000-0000';
            $pessoa->cor_agenda = '#1a5d3e';
            $pessoa->historico = 'Teste histórico Ana Maria';
            $pessoa->ref_profissao = $profissao->id;
            $pessoa->fl_ativo = true;
            $pessoa->store();
            
            $consulta = new Consulta();
            $consulta->parecer = 'Teste';
            $consulta->data_hora_inicio = date('d-m-Y H:i');
            $consulta->data_hora_fim = date('d-m-Y H:i');
            $consulta->ref_pessoa_paciente = $pessoa->id;
            $consulta->store();
                    
            $this->assertEquals( Consulta::getTotalConsultasPessoa($pessoa->id), $value );
            TTransaction::rollback();
        }

        public function testPreenchimentoDataHoraInicioConsulta()
        {
            $value = true;

            TTransaction::open('agenda');

            $profissao = new Profissao();
            $profissao->descricao = 'Profissão teste auto.';
            $profissao->store();
            
            $pessoa = new Pessoa();
            $pessoa->nome = 'Ana Maria';
            $pessoa->cpf = date('048.353.090-57');
            $pessoa->dt_nascimento = ('1998-10-10');
            $pessoa->endereco = 'Rua Teste Auto';
            $pessoa->telefone = '(51)00000-0000';
            $pessoa->cor_agenda = '#1a5d3e';
            $pessoa->historico = 'Teste histórico Ana Maria';
            $pessoa->ref_profissao = $profissao->id;
            $pessoa->fl_ativo = true;
            $pessoa->store();

            $consulta = new Consulta();
            $consulta->parecer = 'Teste';
            $consulta->data_hora_inicio = date('d-m-Y H:i');
            $consulta->data_hora_fim = date('d-m-Y H:i');
            $consulta->ref_pessoa_paciente = $pessoa->id;
            $consulta->store();

            $this->assertEquals( ConsultaService::validaDataHoraInicioConsulta($consulta->id), $value );
            TTransaction::rollback();
        }

        public function testPreenchimentoDataHoraFimConsulta()
        {
            $value = true;

            TTransaction::open('agenda');

            $profissao = new Profissao();
            $profissao->descricao = 'Profissão teste auto.';
            $profissao->store();
            
            $pessoa = new Pessoa();
            $pessoa->nome = 'Ana Maria';
            $pessoa->cpf = date('048.353.090-57');
            $pessoa->dt_nascimento = ('1998-10-10');
            $pessoa->endereco = 'Rua Teste Auto';
            $pessoa->telefone = '(51)00000-0000';
            $pessoa->cor_agenda = '#1a5d3e';
            $pessoa->historico = 'Teste histórico Ana Maria';
            $pessoa->ref_profissao = $profissao->id;
            $pessoa->fl_ativo = true;
            $pessoa->store();

            $consulta = new Consulta();
            $consulta->parecer = 'Teste';
            $consulta->data_hora_inicio = date('d-m-Y H:i');
            $consulta->data_hora_fim = date('d-m-Y H:i');
            $consulta->ref_pessoa_paciente = $pessoa->id;
            $consulta->store();

            $this->assertEquals( ConsultaService::validaDataHoraInicioConsulta($consulta->id), $value );
            TTransaction::rollback();
        }

        public function testPreenchimentoPacienteConsulta()
        {
            $value = true;

            TTransaction::open('agenda');

            $profissao = new Profissao();
            $profissao->descricao = 'Profissão teste auto.';
            $profissao->store();
            
            $pessoa = new Pessoa();
            $pessoa->nome = 'Ana Maria';
            $pessoa->cpf = date('048.353.090-57');
            $pessoa->dt_nascimento = ('1998-10-10');
            $pessoa->endereco = 'Rua Teste Auto';
            $pessoa->telefone = '(51)00000-0000';
            $pessoa->cor_agenda = '#1a5d3e';
            $pessoa->historico = 'Teste histórico Ana Maria';
            $pessoa->ref_profissao = $profissao->id;
            $pessoa->fl_ativo = true;
            $pessoa->store();

            $consulta = new Consulta();
            $consulta->parecer = 'Teste';
            $consulta->data_hora_inicio = date('d-m-Y H:i');
            $consulta->data_hora_fim = date('d-m-Y H:i');
            $consulta->ref_pessoa_paciente = $pessoa->id;
            $consulta->store();

            $this->assertEquals( ConsultaService::validaDataHoraFimConsulta($consulta->id), $value );
            TTransaction::rollback();
        }

        public function testCreateDeleteAgendamento()
        {
            //cria um agendamento e deleta todos. 0 = 0.
            TTransaction::open('agenda');
            
            $value = 0;

            $agendamento = new Agendamento();
            $agendamento->fl_ativo = true;
            $agendamento->data_hora_inicio = '2020-04-15 14:00:00';
            $agendamento->data_hora_fim = '2020-04-15 15:00:00';
            $agendamento->ref_pessoa_paciente = 1;
            $agendamento->store();

            $agendamentos = Agendamento::where('ref_pessoa_paciente', '=', '1')->load();
            foreach ($agendamentos as $agendamento)
            {
                $agendamento->delete();
            }

            $ref_pessoa_paciente = 1;
                    
            $this->assertEquals( Agendamento::getTotalAgendamentosPessoa($ref_pessoa_paciente), $value );
            TTransaction::rollback();
        }

        public function testQuantidadeAgendamentosPorPessoa()
        {
            //busca a quantidade de agendamentos por pessoa. Primeiro deleta todos, depois cria 3. 3 = 3.
            TTransaction::open('agenda');
            
            $value = 3;

            $agendamentos = Agendamento::where('ref_pessoa_paciente', '=', '1')->load();
            foreach ($agendamentos as $agendamento)
            {
                $agendamento->delete();
            }

            $agendamento = new Agendamento();
            $agendamento->fl_ativo = true;
            $agendamento->data_hora_inicio = '2020-04-15 14:00:00';
            $agendamento->data_hora_fim = '2020-04-15 15:00:00';
            $agendamento->ref_pessoa_paciente = 1;
            $agendamento->store();

            $agendamento = new Agendamento();
            $agendamento->fl_ativo = true;
            $agendamento->data_hora_inicio = '2020-04-22 14:00:00';
            $agendamento->data_hora_fim = '2020-04-22 15:00:00';
            $agendamento->ref_pessoa_paciente = 1;
            $agendamento->store();

            $agendamento = new Agendamento();
            $agendamento->fl_ativo = true;
            $agendamento->data_hora_inicio = '2020-04-29 14:00:00';
            $agendamento->data_hora_fim = '2020-04-29 15:00:00';
            $agendamento->ref_pessoa_paciente = 1;
            $agendamento->store();

            $ref_pessoa_paciente = 1;
                    
            $this->assertEquals(Agendamento::getTotalAgendamentosPessoa($ref_pessoa_paciente), $value);
            TTransaction::rollback();
        }

        public function testPreenchimentoDataHoraInicioAgendamento()
        {
            $value = true;

            TTransaction::open('agenda');

            $profissao = new Profissao();
            $profissao->descricao = 'Profissão teste auto.';
            $profissao->store();
            
            $pessoa = new Pessoa();
            $pessoa->nome = 'Ana Maria';
            $pessoa->cpf = date('048.353.090-57');
            $pessoa->dt_nascimento = ('1998-10-10');
            $pessoa->endereco = 'Rua Teste Auto';
            $pessoa->telefone = '(51)00000-0000';
            $pessoa->cor_agenda = '#1a5d3e';
            $pessoa->historico = 'Teste histórico Ana Maria';
            $pessoa->ref_profissao = $profissao->id;
            $pessoa->fl_ativo = true;
            $pessoa->store();

            $agendamento = new Agendamento();
            $agendamento->fl_ativo = true;
            $agendamento->data_hora_inicio = '2020-04-15 14:00:00';
            $agendamento->data_hora_fim = '2020-04-15 15:00:00';
            $agendamento->ref_pessoa_paciente = $pessoa->id;
            $agendamento->store();

            $this->assertEquals( AgendamentoService::validaDataHoraInicioAgendamento($agendamento->id), $value );
            TTransaction::rollback();
        }

        public function testPreenchimentoDataHoraFimAgendamento()
        {
            $value = true;

            TTransaction::open('agenda');

            $profissao = new Profissao();
            $profissao->descricao = 'Profissão teste auto.';
            $profissao->store();
            
            $pessoa = new Pessoa();
            $pessoa->nome = 'Ana Maria';
            $pessoa->cpf = date('048.353.090-57');
            $pessoa->dt_nascimento = ('1998-10-10');
            $pessoa->endereco = 'Rua Teste Auto';
            $pessoa->telefone = '(51)00000-0000';
            $pessoa->cor_agenda = '#1a5d3e';
            $pessoa->historico = 'Teste histórico Ana Maria';
            $pessoa->ref_profissao = $profissao->id;
            $pessoa->fl_ativo = true;
            $pessoa->store();

            $agendamento = new Agendamento();
            $agendamento->fl_ativo = true;
            $agendamento->data_hora_inicio = '2020-04-15 14:00:00';
            $agendamento->data_hora_fim = '2020-04-15 15:00:00';
            $agendamento->ref_pessoa_paciente = $pessoa->id;
            $agendamento->store();

            $this->assertEquals( AgendamentoService::validaDataHoraFimAgendamento($agendamento->id), $value );
            TTransaction::rollback();
        }

        public function testPreenchimentoPacienteAgendamento()
        {
            $value = true;

            TTransaction::open('agenda');

            $profissao = new Profissao();
            $profissao->descricao = 'Profissão teste auto.';
            $profissao->store();
            
            $pessoa = new Pessoa();
            $pessoa->nome = 'Ana Maria';
            $pessoa->cpf = date('048.353.090-57');
            $pessoa->dt_nascimento = ('1998-10-10');
            $pessoa->endereco = 'Rua Teste Auto';
            $pessoa->telefone = '(51)00000-0000';
            $pessoa->cor_agenda = '#1a5d3e';
            $pessoa->historico = 'Teste histórico Ana Maria';
            $pessoa->ref_profissao = $profissao->id;
            $pessoa->fl_ativo = true;
            $pessoa->store();

            $agendamento = new Agendamento();
            $agendamento->fl_ativo = true;
            $agendamento->data_hora_inicio = '2020-04-15 14:00:00';
            $agendamento->data_hora_fim = '2020-04-15 15:00:00';
            $agendamento->ref_pessoa_paciente = $pessoa->id;
            $agendamento->store();

            $this->assertEquals( AgendamentoService::validaPaciente($agendamento->id), $value );
            TTransaction::rollback();
        }

        public function testCreateDeleteProfissao()
        {
            //insere uma profissão e deleta todas as profisões. 0 = 0.
            TTransaction::open('agenda');
            
            $value = 2;

            $profissao = new Profissao();
            $profissao->descricao = 'Profissão teste auto.';
            $profissao->store();

            $pessoa = new Pessoa();
            $pessoa->nome = 'Ana Maria';
            $pessoa->cpf = date('048.353.090-57');
            $pessoa->dt_nascimento = ('1998-10-10');
            $pessoa->endereco = 'Rua Teste Auto';
            $pessoa->telefone = '(51)00000-0000';
            $pessoa->cor_agenda = '#1a5d3e';
            $pessoa->historico = 'Teste histórico Ana Maria';
            $pessoa->ref_profissao = $profissao->id;
            $pessoa->fl_ativo = true;
            $pessoa->store();

            $pessoa2 = new Pessoa();
            $pessoa2->nome = 'João';
            $pessoa2->cpf = date('048.353.090-57');
            $pessoa2->dt_nascimento = ('1998-10-10');
            $pessoa2->endereco = 'Rua Teste Auto';
            $pessoa2->telefone = '(51)00000-0000';
            $pessoa2->cor_agenda = '#1a5d3e';
            $pessoa2->historico = 'Teste histórico Ana Maria';
            $pessoa2->ref_profissao = $profissao->id;
            $pessoa2->fl_ativo = true;
            $pessoa2->store();

            $count = Pessoa::where('ref_profissao', '=', $profissao->id)->count();

            $this->assertEquals( $count, $value );
            TTransaction::rollback();
        }

        public function testTamanhoPreenchimentoDescricaoProfissao()
        {
            $value = true;

            TTransaction::open('agenda');

            $profissao = new Profissao();
            $profissao->descricao = 'Profissão teste auto.';
            $profissao->store();

            $this->assertEquals( Profissao::validaTamanho($profissao->id), $value );
            
            TTransaction::rollback();

        }

        public function testCreatePessoa()
        {
            $value = 1;
            
            TTransaction::open('agenda');

            $profissao = new Profissao();
            $profissao->descricao = 'Profissão teste auto.';
            $profissao->store();
            
            $pessoa = new Pessoa();
            $pessoa->nome = 'Ana Maria';
            $pessoa->cpf = date('048.353.090-57');
            $pessoa->dt_nascimento = ('1998-10-10');
            $pessoa->endereco = 'Rua Teste Auto';
            $pessoa->telefone = '(51)00000-0000';
            $pessoa->cor_agenda = '#1a5d3e';
            $pessoa->historico = 'Teste histórico Ana Maria';
            $pessoa->ref_profissao = $profissao->id;
            $pessoa->fl_ativo = true;
            $pessoa->store();

            $count = Pessoa::where('id', '=', $pessoa->id)->count();
                    
            $this->assertEquals($count, $value );
            TTransaction::rollback();
        }

public function testCreateDeleteProfissao1()
        {
            //insere uma profissão e deleta todas as profisões. 0 = 0.
            TTransaction::open('agenda');
            
            $value = 2;

            $profissao = new Profissao();
            $profissao->descricao = 'Profissão teste auto.';
            $profissao->store();

            $pessoa = new Pessoa();
            $pessoa->nome = 'Ana Maria';
            $pessoa->cpf = date('048.353.090-57');
            $pessoa->dt_nascimento = ('1998-10-10');
            $pessoa->endereco = 'Rua Teste Auto';
            $pessoa->telefone = '(51)00000-0000';
            $pessoa->cor_agenda = '#1a5d3e';
            $pessoa->historico = 'Teste histórico Ana Maria';
            $pessoa->ref_profissao = $profissao->id;
            $pessoa->fl_ativo = true;
            $pessoa->store();

            $pessoa2 = new Pessoa();
            $pessoa2->nome = 'João';
            $pessoa2->cpf = date('048.353.090-57');
            $pessoa2->dt_nascimento = ('1998-10-10');
            $pessoa2->endereco = 'Rua Teste Auto';
            $pessoa2->telefone = '(51)00000-0000';
            $pessoa2->cor_agenda = '#1a5d3e';
            $pessoa2->historico = 'Teste histórico Ana Maria';
            $pessoa2->ref_profissao = $profissao->id;
            $pessoa2->fl_ativo = true;
            $pessoa2->store();

            $count = Pessoa::where('ref_profissao', '=', $profissao->id)->count();

            $this->assertEquals( $count, $value );
            TTransaction::rollback();
        }
        public function testCreateDeleteProfissao2()
        {
            //insere uma profissão e deleta todas as profisões. 0 = 0.
            TTransaction::open('agenda');
            
            $value = 2;

            $profissao = new Profissao();
            $profissao->descricao = 'Profissão teste auto.';
            $profissao->store();

            $pessoa = new Pessoa();
            $pessoa->nome = 'Ana Maria';
            $pessoa->cpf = date('048.353.090-57');
            $pessoa->dt_nascimento = ('1998-10-10');
            $pessoa->endereco = 'Rua Teste Auto';
            $pessoa->telefone = '(51)00000-0000';
            $pessoa->cor_agenda = '#1a5d3e';
            $pessoa->historico = 'Teste histórico Ana Maria';
            $pessoa->ref_profissao = $profissao->id;
            $pessoa->fl_ativo = true;
            $pessoa->store();

            $pessoa2 = new Pessoa();
            $pessoa2->nome = 'João';
            $pessoa2->cpf = date('048.353.090-57');
            $pessoa2->dt_nascimento = ('1998-10-10');
            $pessoa2->endereco = 'Rua Teste Auto';
            $pessoa2->telefone = '(51)00000-0000';
            $pessoa2->cor_agenda = '#1a5d3e';
            $pessoa2->historico = 'Teste histórico Ana Maria';
            $pessoa2->ref_profissao = $profissao->id;
            $pessoa2->fl_ativo = true;
            $pessoa2->store();

            $count = Pessoa::where('ref_profissao', '=', $profissao->id)->count();

            $this->assertEquals( $count, $value );
            TTransaction::rollback();
        }
        public function testCreateDeleteProfissao3()
        {
            //insere uma profissão e deleta todas as profisões. 0 = 0.
            TTransaction::open('agenda');
            
            $value = 2;

            $profissao = new Profissao();
            $profissao->descricao = 'Profissão teste auto.';
            $profissao->store();

            $pessoa = new Pessoa();
            $pessoa->nome = 'Ana Maria';
            $pessoa->cpf = date('048.353.090-57');
            $pessoa->dt_nascimento = ('1998-10-10');
            $pessoa->endereco = 'Rua Teste Auto';
            $pessoa->telefone = '(51)00000-0000';
            $pessoa->cor_agenda = '#1a5d3e';
            $pessoa->historico = 'Teste histórico Ana Maria';
            $pessoa->ref_profissao = $profissao->id;
            $pessoa->fl_ativo = true;
            $pessoa->store();

            $pessoa2 = new Pessoa();
            $pessoa2->nome = 'João';
            $pessoa2->cpf = date('048.353.090-57');
            $pessoa2->dt_nascimento = ('1998-10-10');
            $pessoa2->endereco = 'Rua Teste Auto';
            $pessoa2->telefone = '(51)00000-0000';
            $pessoa2->cor_agenda = '#1a5d3e';
            $pessoa2->historico = 'Teste histórico Ana Maria';
            $pessoa2->ref_profissao = $profissao->id;
            $pessoa2->fl_ativo = true;
            $pessoa2->store();

            $count = Pessoa::where('ref_profissao', '=', $profissao->id)->count();

            $this->assertEquals( $count, $value );
            TTransaction::rollback();
        }
        public function testCreateDeleteProfissao4()
        {
            //insere uma profissão e deleta todas as profisões. 0 = 0.
            TTransaction::open('agenda');
            
            $value = 2;

            $profissao = new Profissao();
            $profissao->descricao = 'Profissão teste auto.';
            $profissao->store();

            $pessoa = new Pessoa();
            $pessoa->nome = 'Ana Maria';
            $pessoa->cpf = date('048.353.090-57');
            $pessoa->dt_nascimento = ('1998-10-10');
            $pessoa->endereco = 'Rua Teste Auto';
            $pessoa->telefone = '(51)00000-0000';
            $pessoa->cor_agenda = '#1a5d3e';
            $pessoa->historico = 'Teste histórico Ana Maria';
            $pessoa->ref_profissao = $profissao->id;
            $pessoa->fl_ativo = true;
            $pessoa->store();

            $pessoa2 = new Pessoa();
            $pessoa2->nome = 'João';
            $pessoa2->cpf = date('048.353.090-57');
            $pessoa2->dt_nascimento = ('1998-10-10');
            $pessoa2->endereco = 'Rua Teste Auto';
            $pessoa2->telefone = '(51)00000-0000';
            $pessoa2->cor_agenda = '#1a5d3e';
            $pessoa2->historico = 'Teste histórico Ana Maria';
            $pessoa2->ref_profissao = $profissao->id;
            $pessoa2->fl_ativo = true;
            $pessoa2->store();

            $count = Pessoa::where('ref_profissao', '=', $profissao->id)->count();

            $this->assertEquals( $count, $value );
            TTransaction::rollback();
        }
        public function testCreateDeleteProfissao5()
        {
            //insere uma profissão e deleta todas as profisões. 0 = 0.
            TTransaction::open('agenda');
            
            $value = 2;

            $profissao = new Profissao();
            $profissao->descricao = 'Profissão teste auto.';
            $profissao->store();

            $pessoa = new Pessoa();
            $pessoa->nome = 'Ana Maria';
            $pessoa->cpf = date('048.353.090-57');
            $pessoa->dt_nascimento = ('1998-10-10');
            $pessoa->endereco = 'Rua Teste Auto';
            $pessoa->telefone = '(51)00000-0000';
            $pessoa->cor_agenda = '#1a5d3e';
            $pessoa->historico = 'Teste histórico Ana Maria';
            $pessoa->ref_profissao = $profissao->id;
            $pessoa->fl_ativo = true;
            $pessoa->store();

            $pessoa2 = new Pessoa();
            $pessoa2->nome = 'João';
            $pessoa2->cpf = date('048.353.090-57');
            $pessoa2->dt_nascimento = ('1998-10-10');
            $pessoa2->endereco = 'Rua Teste Auto';
            $pessoa2->telefone = '(51)00000-0000';
            $pessoa2->cor_agenda = '#1a5d3e';
            $pessoa2->historico = 'Teste histórico Ana Maria';
            $pessoa2->ref_profissao = $profissao->id;
            $pessoa2->fl_ativo = true;
            $pessoa2->store();

            $count = Pessoa::where('ref_profissao', '=', $profissao->id)->count();

            $this->assertEquals( $count, $value );
            TTransaction::rollback();
        }
        public function testCreateDeleteProfissao6()
        {
            //insere uma profissão e deleta todas as profisões. 0 = 0.
            TTransaction::open('agenda');
            
            $value = 2;

            $profissao = new Profissao();
            $profissao->descricao = 'Profissão teste auto.';
            $profissao->store();

            $pessoa = new Pessoa();
            $pessoa->nome = 'Ana Maria';
            $pessoa->cpf = date('048.353.090-57');
            $pessoa->dt_nascimento = ('1998-10-10');
            $pessoa->endereco = 'Rua Teste Auto';
            $pessoa->telefone = '(51)00000-0000';
            $pessoa->cor_agenda = '#1a5d3e';
            $pessoa->historico = 'Teste histórico Ana Maria';
            $pessoa->ref_profissao = $profissao->id;
            $pessoa->fl_ativo = true;
            $pessoa->store();

            $pessoa2 = new Pessoa();
            $pessoa2->nome = 'João';
            $pessoa2->cpf = date('048.353.090-57');
            $pessoa2->dt_nascimento = ('1998-10-10');
            $pessoa2->endereco = 'Rua Teste Auto';
            $pessoa2->telefone = '(51)00000-0000';
            $pessoa2->cor_agenda = '#1a5d3e';
            $pessoa2->historico = 'Teste histórico Ana Maria';
            $pessoa2->ref_profissao = $profissao->id;
            $pessoa2->fl_ativo = true;
            $pessoa2->store();

            $count = Pessoa::where('ref_profissao', '=', $profissao->id)->count();

            $this->assertEquals( $count, $value );
            TTransaction::rollback();
        }
        public function testCreateDeleteProfissao7()
        {
            //insere uma profissão e deleta todas as profisões. 0 = 0.
            TTransaction::open('agenda');
            
            $value = 2;

            $profissao = new Profissao();
            $profissao->descricao = 'Profissão teste auto.';
            $profissao->store();

            $pessoa = new Pessoa();
            $pessoa->nome = 'Ana Maria';
            $pessoa->cpf = date('048.353.090-57');
            $pessoa->dt_nascimento = ('1998-10-10');
            $pessoa->endereco = 'Rua Teste Auto';
            $pessoa->telefone = '(51)00000-0000';
            $pessoa->cor_agenda = '#1a5d3e';
            $pessoa->historico = 'Teste histórico Ana Maria';
            $pessoa->ref_profissao = $profissao->id;
            $pessoa->fl_ativo = true;
            $pessoa->store();

            $pessoa2 = new Pessoa();
            $pessoa2->nome = 'João';
            $pessoa2->cpf = date('048.353.090-57');
            $pessoa2->dt_nascimento = ('1998-10-10');
            $pessoa2->endereco = 'Rua Teste Auto';
            $pessoa2->telefone = '(51)00000-0000';
            $pessoa2->cor_agenda = '#1a5d3e';
            $pessoa2->historico = 'Teste histórico Ana Maria';
            $pessoa2->ref_profissao = $profissao->id;
            $pessoa2->fl_ativo = true;
            $pessoa2->store();

            $count = Pessoa::where('ref_profissao', '=', $profissao->id)->count();

            $this->assertEquals( $count, $value );
            TTransaction::rollback();
        }
        public function testCreateDeleteProfissao8()
        {
            //insere uma profissão e deleta todas as profisões. 0 = 0.
            TTransaction::open('agenda');
            
            $value = 2;

            $profissao = new Profissao();
            $profissao->descricao = 'Profissão teste auto.';
            $profissao->store();

            $pessoa = new Pessoa();
            $pessoa->nome = 'Ana Maria';
            $pessoa->cpf = date('048.353.090-57');
            $pessoa->dt_nascimento = ('1998-10-10');
            $pessoa->endereco = 'Rua Teste Auto';
            $pessoa->telefone = '(51)00000-0000';
            $pessoa->cor_agenda = '#1a5d3e';
            $pessoa->historico = 'Teste histórico Ana Maria';
            $pessoa->ref_profissao = $profissao->id;
            $pessoa->fl_ativo = true;
            $pessoa->store();

            $pessoa2 = new Pessoa();
            $pessoa2->nome = 'João';
            $pessoa2->cpf = date('048.353.090-57');
            $pessoa2->dt_nascimento = ('1998-10-10');
            $pessoa2->endereco = 'Rua Teste Auto';
            $pessoa2->telefone = '(51)00000-0000';
            $pessoa2->cor_agenda = '#1a5d3e';
            $pessoa2->historico = 'Teste histórico Ana Maria';
            $pessoa2->ref_profissao = $profissao->id;
            $pessoa2->fl_ativo = true;
            $pessoa2->store();

            $count = Pessoa::where('ref_profissao', '=', $profissao->id)->count();

            $this->assertEquals( $count, $value );
            TTransaction::rollback();
        }
        public function testCreateDeleteProfissao9()
        {
            //insere uma profissão e deleta todas as profisões. 0 = 0.
            TTransaction::open('agenda');
            
            $value = 2;

            $profissao = new Profissao();
            $profissao->descricao = 'Profissão teste auto.';
            $profissao->store();

            $pessoa = new Pessoa();
            $pessoa->nome = 'Ana Maria';
            $pessoa->cpf = date('048.353.090-57');
            $pessoa->dt_nascimento = ('1998-10-10');
            $pessoa->endereco = 'Rua Teste Auto';
            $pessoa->telefone = '(51)00000-0000';
            $pessoa->cor_agenda = '#1a5d3e';
            $pessoa->historico = 'Teste histórico Ana Maria';
            $pessoa->ref_profissao = $profissao->id;
            $pessoa->fl_ativo = true;
            $pessoa->store();

            $pessoa2 = new Pessoa();
            $pessoa2->nome = 'João';
            $pessoa2->cpf = date('048.353.090-57');
            $pessoa2->dt_nascimento = ('1998-10-10');
            $pessoa2->endereco = 'Rua Teste Auto';
            $pessoa2->telefone = '(51)00000-0000';
            $pessoa2->cor_agenda = '#1a5d3e';
            $pessoa2->historico = 'Teste histórico Ana Maria';
            $pessoa2->ref_profissao = $profissao->id;
            $pessoa2->fl_ativo = true;
            $pessoa2->store();

            $count = Pessoa::where('ref_profissao', '=', $profissao->id)->count();

            $this->assertEquals( $count, $value );
            TTransaction::rollback();
        }
        public function testCreateDeleteProfissao10()
        {
            //insere uma profissão e deleta todas as profisões. 0 = 0.
            TTransaction::open('agenda');
            
            $value = 2;

            $profissao = new Profissao();
            $profissao->descricao = 'Profissão teste auto.';
            $profissao->store();

            $pessoa = new Pessoa();
            $pessoa->nome = 'Ana Maria';
            $pessoa->cpf = date('048.353.090-57');
            $pessoa->dt_nascimento = ('1998-10-10');
            $pessoa->endereco = 'Rua Teste Auto';
            $pessoa->telefone = '(51)00000-0000';
            $pessoa->cor_agenda = '#1a5d3e';
            $pessoa->historico = 'Teste histórico Ana Maria';
            $pessoa->ref_profissao = $profissao->id;
            $pessoa->fl_ativo = true;
            $pessoa->store();

            $pessoa2 = new Pessoa();
            $pessoa2->nome = 'João';
            $pessoa2->cpf = date('048.353.090-57');
            $pessoa2->dt_nascimento = ('1998-10-10');
            $pessoa2->endereco = 'Rua Teste Auto';
            $pessoa2->telefone = '(51)00000-0000';
            $pessoa2->cor_agenda = '#1a5d3e';
            $pessoa2->historico = 'Teste histórico Ana Maria';
            $pessoa2->ref_profissao = $profissao->id;
            $pessoa2->fl_ativo = true;
            $pessoa2->store();

            $count = Pessoa::where('ref_profissao', '=', $profissao->id)->count();

            $this->assertEquals( $count, $value );
            TTransaction::rollback();
        }
        public function testCreateDeleteProfissao11()
        {
            //insere uma profissão e deleta todas as profisões. 0 = 0.
            TTransaction::open('agenda');
            
            $value = 2;

            $profissao = new Profissao();
            $profissao->descricao = 'Profissão teste auto.';
            $profissao->store();

            $pessoa = new Pessoa();
            $pessoa->nome = 'Ana Maria';
            $pessoa->cpf = date('048.353.090-57');
            $pessoa->dt_nascimento = ('1998-10-10');
            $pessoa->endereco = 'Rua Teste Auto';
            $pessoa->telefone = '(51)00000-0000';
            $pessoa->cor_agenda = '#1a5d3e';
            $pessoa->historico = 'Teste histórico Ana Maria';
            $pessoa->ref_profissao = $profissao->id;
            $pessoa->fl_ativo = true;
            $pessoa->store();

            $pessoa2 = new Pessoa();
            $pessoa2->nome = 'João';
            $pessoa2->cpf = date('048.353.090-57');
            $pessoa2->dt_nascimento = ('1998-10-10');
            $pessoa2->endereco = 'Rua Teste Auto';
            $pessoa2->telefone = '(51)00000-0000';
            $pessoa2->cor_agenda = '#1a5d3e';
            $pessoa2->historico = 'Teste histórico Ana Maria';
            $pessoa2->ref_profissao = $profissao->id;
            $pessoa2->fl_ativo = true;
            $pessoa2->store();

            $count = Pessoa::where('ref_profissao', '=', $profissao->id)->count();

            $this->assertEquals( $count, $value );
            TTransaction::rollback();
        }
        public function testCreateDeleteProfissao12()
        {
            //insere uma profissão e deleta todas as profisões. 0 = 0.
            TTransaction::open('agenda');
            
            $value = 2;

            $profissao = new Profissao();
            $profissao->descricao = 'Profissão teste auto.';
            $profissao->store();

            $pessoa = new Pessoa();
            $pessoa->nome = 'Ana Maria';
            $pessoa->cpf = date('048.353.090-57');
            $pessoa->dt_nascimento = ('1998-10-10');
            $pessoa->endereco = 'Rua Teste Auto';
            $pessoa->telefone = '(51)00000-0000';
            $pessoa->cor_agenda = '#1a5d3e';
            $pessoa->historico = 'Teste histórico Ana Maria';
            $pessoa->ref_profissao = $profissao->id;
            $pessoa->fl_ativo = true;
            $pessoa->store();

            $pessoa2 = new Pessoa();
            $pessoa2->nome = 'João';
            $pessoa2->cpf = date('048.353.090-57');
            $pessoa2->dt_nascimento = ('1998-10-10');
            $pessoa2->endereco = 'Rua Teste Auto';
            $pessoa2->telefone = '(51)00000-0000';
            $pessoa2->cor_agenda = '#1a5d3e';
            $pessoa2->historico = 'Teste histórico Ana Maria';
            $pessoa2->ref_profissao = $profissao->id;
            $pessoa2->fl_ativo = true;
            $pessoa2->store();

            $count = Pessoa::where('ref_profissao', '=', $profissao->id)->count();

            $this->assertEquals( $count, $value );
            TTransaction::rollback();
        }
        public function testCreateDeleteProfissao13()
        {
            //insere uma profissão e deleta todas as profisões. 0 = 0.
            TTransaction::open('agenda');
            
            $value = 2;

            $profissao = new Profissao();
            $profissao->descricao = 'Profissão teste auto.';
            $profissao->store();

            $pessoa = new Pessoa();
            $pessoa->nome = 'Ana Maria';
            $pessoa->cpf = date('048.353.090-57');
            $pessoa->dt_nascimento = ('1998-10-10');
            $pessoa->endereco = 'Rua Teste Auto';
            $pessoa->telefone = '(51)00000-0000';
            $pessoa->cor_agenda = '#1a5d3e';
            $pessoa->historico = 'Teste histórico Ana Maria';
            $pessoa->ref_profissao = $profissao->id;
            $pessoa->fl_ativo = true;
            $pessoa->store();

            $pessoa2 = new Pessoa();
            $pessoa2->nome = 'João';
            $pessoa2->cpf = date('048.353.090-57');
            $pessoa2->dt_nascimento = ('1998-10-10');
            $pessoa2->endereco = 'Rua Teste Auto';
            $pessoa2->telefone = '(51)00000-0000';
            $pessoa2->cor_agenda = '#1a5d3e';
            $pessoa2->historico = 'Teste histórico Ana Maria';
            $pessoa2->ref_profissao = $profissao->id;
            $pessoa2->fl_ativo = true;
            $pessoa2->store();

            $count = Pessoa::where('ref_profissao', '=', $profissao->id)->count();

            $this->assertEquals( $count, $value );
            TTransaction::rollback();
        }
        
        
       /* public function testPreenchimentoNomePessoa()
        {

        }

        public function testPreenchimentoCpfPessoa()
        {
            
        }

        public function testPreenchimentoDataNascimentoPessoa()
        {
            
        }

        public function testPreenchimentoTelefonePessoa()
        {
            
        }

        public function testPreenchimentoProfissaoPessoa()
        {
            
        }

        public function testPreenchimentoEnderecoPessoa()
        {
            
        }

        public function testPreenchimentoHistoricoPessoa()
        {
            
        }

        public function testSomenteLetrasNomePessoa()
        {
            
        }

        public function testFormatoDataNascimentoPessoa()
        {
            
        }*/

        public function testTamanhoPreenchimentoNomePessoa()
        {
            $value = true;

            TTransaction::open('agenda');

            $pessoa = new Pessoa();
            $pessoa->nome = 'Ana Maria';
            $pessoa->cpf = date('048.353.090-57');
            $pessoa->dt_nascimento = ('1998-10-10');
            $pessoa->endereco = 'Rua Teste Auto';
            $pessoa->telefone = '(51)00000-0000';
            $pessoa->cor_agenda = '#1a5d3e';
            $pessoa->historico = 'Teste histórico Ana Maria';
            $pessoa->fl_ativo = true;
            $pessoa->store();

            $this->assertEquals( Pessoa::validaTamanho($pessoa->id), $value );
            
            TTransaction::rollback();
  
        }
        public function testTamanhoPreenchimentoCPFPessoa()
        {
            $value = true;

            TTransaction::open('agenda');

            $pessoa = new Pessoa();
            $pessoa->nome = 'Ana Maria';
            $pessoa->cpf = date('048.353.090-57');
            $pessoa->dt_nascimento = ('1998-10-10');
            $pessoa->endereco = 'Rua Teste Auto';
            $pessoa->telefone = '(51)00000-0000';
            $pessoa->cor_agenda = '#1a5d3e';
            $pessoa->historico = 'Teste histórico Ana Maria';
            $pessoa->fl_ativo = true;
            $pessoa->store();

            $this->assertEquals( Pessoa::validaTamanho($pessoa->id), $value );
            
            TTransaction::rollback();
  
        }
        public function testTamanhoPreenchimentoEnderecoPessoa()
        {
            $value = true;

            TTransaction::open('agenda');

            $pessoa = new Pessoa();
            $pessoa->nome = 'Ana Maria';
            $pessoa->cpf = date('048.353.090-57');
            $pessoa->dt_nascimento = ('1998-10-10');
            $pessoa->endereco = 'Rua Teste Auto';
            $pessoa->telefone = '(51)00000-0000';
            $pessoa->cor_agenda = '#1a5d3e';
            $pessoa->historico = 'Teste histórico Ana Maria';
            $pessoa->fl_ativo = true;
            $pessoa->store();

            $this->assertEquals( Pessoa::validaTamanho($pessoa->id), $value );
            
            TTransaction::rollback();
  
        }
        public function testTamanhoPreenchimentoTelefonePessoa()
        {
            $value = true;

            TTransaction::open('agenda');

            $pessoa = new Pessoa();
            $pessoa->nome = 'Ana Maria';
            $pessoa->cpf = date('048.353.090-57');
            $pessoa->dt_nascimento = ('1998-10-10');
            $pessoa->endereco = 'Rua Teste Auto';
            $pessoa->telefone = '(51)00000-0000';
            $pessoa->cor_agenda = '#1a5d3e';
            $pessoa->historico = 'Teste histórico Ana Maria';
            $pessoa->fl_ativo = true;
            $pessoa->store();

            $this->assertEquals( Pessoa::validaTamanho($pessoa->id), $value );
            
            TTransaction::rollback();
  
        }
        public function testTamanhoPreenchimentoHistoricoPessoa()
        {
            $value = true;

            TTransaction::open('agenda');

            $pessoa = new Pessoa();
            $pessoa->nome = 'Ana Maria';
            $pessoa->cpf = date('048.353.090-57');
            $pessoa->dt_nascimento = ('1998-10-10');
            $pessoa->endereco = 'Rua Teste Auto';
            $pessoa->telefone = '(51)00000-0000';
            $pessoa->cor_agenda = '#1a5d3e';
            $pessoa->historico = 'Teste histórico Ana Maria';
            $pessoa->fl_ativo = true;
            $pessoa->store();

            $this->assertEquals( Pessoa::validaTamanho($pessoa->id), $value );
            
            TTransaction::rollback();
  
        }
    }
?>