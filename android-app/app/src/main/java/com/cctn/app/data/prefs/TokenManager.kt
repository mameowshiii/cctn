package com.cctn.app.data.prefs

import android.content.Context
import android.content.SharedPreferences
import dagger.hilt.android.qualifiers.ApplicationContext
import javax.inject.Inject
import javax.inject.Singleton

@Singleton
class TokenManager @Inject constructor(
    @ApplicationContext context: Context
) {
    private val prefs: SharedPreferences =
        context.getSharedPreferences("cctn_prefs", Context.MODE_PRIVATE)

    companion object {
        private const val KEY_TOKEN = "auth_token"
        private const val KEY_CLIENT_ID = "client_id"
        private const val KEY_CLIENT_NAME = "client_name"
        private const val KEY_ACCOUNT_NUMBER = "account_number"
    }

    fun saveToken(token: String) = prefs.edit().putString(KEY_TOKEN, token).apply()
    fun getToken(): String? = prefs.getString(KEY_TOKEN, null)
    fun clearToken() = prefs.edit().remove(KEY_TOKEN).apply()

    fun saveClientInfo(id: Int, fullName: String, accountNumber: String) {
        prefs.edit()
            .putInt(KEY_CLIENT_ID, id)
            .putString(KEY_CLIENT_NAME, fullName)
            .putString(KEY_ACCOUNT_NUMBER, accountNumber)
            .apply()
    }

    fun getClientName(): String = prefs.getString(KEY_CLIENT_NAME, "") ?: ""
    fun getAccountNumber(): String = prefs.getString(KEY_ACCOUNT_NUMBER, "") ?: ""

    fun clearAll() = prefs.edit().clear().apply()

    fun isLoggedIn(): Boolean = !getToken().isNullOrEmpty()
}
