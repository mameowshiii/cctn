package com.cctn.app.data.repository

import com.cctn.app.data.api.ApiService
import com.cctn.app.data.model.AuthResponse
import com.cctn.app.data.model.LoginRequest
import com.cctn.app.data.model.RegisterRequest
import com.cctn.app.data.model.GenericResponse
import com.cctn.app.util.Result
import com.cctn.app.util.safeApiCall
import javax.inject.Inject
import javax.inject.Singleton

@Singleton
class AuthRepository @Inject constructor(private val api: ApiService) {

    suspend fun login(loginInput: String, password: String): Result<AuthResponse> =
        safeApiCall { api.login(LoginRequest(loginInput, password)) }

    suspend fun register(request: RegisterRequest): Result<AuthResponse> =
        safeApiCall { api.register(request) }

    suspend fun logout(): Result<GenericResponse> =
        safeApiCall { api.logout() }
}
