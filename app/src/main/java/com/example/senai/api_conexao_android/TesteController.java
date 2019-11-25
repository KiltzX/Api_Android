package com.example.senai.api_conexao_android;

import android.content.Context;
import android.util.Log;

import com.android.volley.VolleyError;

import java.util.HashMap;

/**
 * Classe do tipo CONTROLLER - liga a interface do usuário com o controle de dados
 * do tipo MODEL (AppModelSingleton.java) é a camada do \"meio\"
 */
public class TesteController
        extends AbstractController
        implements IEnviadorTextoSimplesPHP {

    public TesteController(Context appContext) {
        super(appContext);
    }

    @Override
    public void enviarParaPHP(String texto) {
        HashMap<String,String> hm = new HashMap();
        hm.put("comando", "teste");
        hm.put("valor", texto);
        AppModelSingleton.getInstance().
                registrarCallback(this);
        AppModelSingleton.getInstance().
                enviarRequisicao(this.getAppContext(),hm);
    }

    /**
     * Quando este objeto for registrado no callback de AppModelSingleton em enviarParaPHP,
     * automaticamente quando o PHP enviar uma resposta de volta, o AppModelSingleton chamará
     * eventoRetornouOK se a requisição funcionou ou
     * eventoRetornouErro se a requisição não funcionou
     * @param response
     */
    @Override
    public void eventoRetornouOk(Object response) {
        String resposta = String.valueOf(response);
        Log.d(this.getClass().toString(), "Evento Retornou!" + response);
        this.getmListenerView().eventoRetornouOk(response);

    }

    @Override
    public void eventoRetornouErro(VolleyError error) {
        Log.d(this.getClass().toString(), "Evento Retornou erro!" + error.toString());
        this.getmListenerView().eventoRetornouErro(error);
    }

}
