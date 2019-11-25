package com.example.senai.api_conexao_android;

import android.content.Context;

public abstract class AbstractController implements IDadosEventListener{
    private Context appContext;
    private IDadosEventListener mListenerView;

    public AbstractController(Context appContext) {
        this.appContext = appContext;
        //o registro de callback da view é feito por essa linha automaticamente
        this.mListenerView = (IDadosEventListener) appContext;
    }

    public Context getAppContext() {
        return appContext;
    }
    public IDadosEventListener getmListenerView() {
        return mListenerView;
    }

}
