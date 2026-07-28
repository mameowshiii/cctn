package com.cctn.app.ui.auth

import androidx.lifecycle.LiveData
import androidx.lifecycle.MutableLiveData
import androidx.lifecycle.ViewModel
import androidx.lifecycle.viewModelScope
import com.cctn.app.data.model.AuthResponse
import com.cctn.app.data.model.RegisterRequest
import com.cctn.app.data.prefs.TokenManager
import com.cctn.app.data.repository.AuthRepository
import com.cctn.app.util.Result
import dagger.hilt.android.lifecycle.HiltViewModel
import kotlinx.coroutines.launch
import javax.inject.Inject

@HiltViewModel
class AuthViewModel @Inject constructor(
    private val authRepo: AuthRepository,
    private val tokenManager: TokenManager
) : ViewModel() {

    private val _loginState = MutableLiveData<Result<AuthResponse>>()
    val loginState: LiveData<Result<AuthResponse>> get() = _loginState

    private val _registerState = MutableLiveData<Result<AuthResponse>>()
    val registerState: LiveData<Result<AuthResponse>> get() = _registerState

    fun login(loginInput: String, password: String) = viewModelScope.launch {
        _loginState.value = Result.Loading
        val result = authRepo.login(loginInput, password)
        if (result is Result.Success) {
            result.data.token?.let { tokenManager.saveToken(it) }
            result.data.client?.let {
                tokenManager.saveClientInfo(it.id, it.fullName, it.accountNumber)
            }
        }
        _loginState.value = result
    }

    fun register(request: RegisterRequest) = viewModelScope.launch {
        _registerState.value = Result.Loading
        val result = authRepo.register(request)
        if (result is Result.Success) {
            result.data.token?.let { tokenManager.saveToken(it) }
            result.data.client?.let {
                tokenManager.saveClientInfo(it.id, it.fullName, it.accountNumber)
            }
        }
        _registerState.value = result
    }

    fun logout() = viewModelScope.launch {
        authRepo.logout()
        tokenManager.clearAll()
    }

    fun isLoggedIn() = tokenManager.isLoggedIn()
}
