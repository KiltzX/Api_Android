package com.example.senai.api_conexao_android;

import com.android.volley.VolleyError;

public interface IDadosEventListener<T> {
    void eventoRetornouOk(T response);
    void eventoRetornouErro(VolleyError error);
}
