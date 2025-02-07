## Problemas encontrados:

- api-football: 
Documentação da API atende em partes, dá para utilizar porém, não tem um explicação detalhada dos parametros de entrada e resposta.
Como plano gratuíto fica com o limite de 100 requisições por dia, as 100 requisições foram consumidas muito rapidamente nos testes.
Afim de tentar burlar esta deficiência, criamos outra conta porém, foi bloqueada/suspensa as duas(Achamos que por ter as informações parecidas entre as duas).
Por este modo a utilização desta API para realização do teste não foi possível.

Optamos por utilizar a football-data.org para concluir o teste.

- football-data.org: 
Documentação com muito ou quase nada de detalhamento dos parametros de entrada e resposta, não oferece nem mesmo um exemplo para sua utilização, deixando o tempo mais curto para conclusão.
Plano gratuíto fica com 10 requisições por minuto, impedindo o avanço de forma rápida.

Até o momento todos os problemas encontrados na realização do teste foram relacionados a estas duas APIs.
Por algum motivo alguns endpoints retornam problemas no token mesmo informando.(Alguns funcionam outras não)

Para ajudar a entregar algo funcional, crie uma API em meu dominio: api.mkbits.com.br.
Nesta API retorna alguns dados fakes.

https://api.mkbits.com.br?action=competitions
Retornar os nomes das competições

https://api.mkbits.com.br?action=times&competition=1
Retorna os times que estão na competição

https://api.mkbits.com.br?action=matches&competition=1
Retorna os jogos desta competição

https://api.mkbits.com.br?action=matches&competition=1&time=1
Retorna os jogos desta competição com time especifico
