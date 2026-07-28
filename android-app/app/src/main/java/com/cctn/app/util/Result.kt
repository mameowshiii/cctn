package com.cctn.app.util

import retrofit2.Response

sealed class Result<out T> {
    data class Success<T>(val data: T) : Result<T>()
    data class Error(val message: String, val code: Int? = null) : Result<Nothing>()
    object Loading : Result<Nothing>()
}

suspend fun <T> safeApiCall(call: suspend () -> Response<T>): Result<T> {
    return try {
        val response = call()
        if (response.isSuccessful) {
            val body = response.body()
            if (body != null) {
                Result.Success(body)
            } else {
                Result.Error("Empty response body", response.code())
            }
        } else {
            Result.Error(
                response.errorBody()?.string() ?: "Server error",
                response.code()
            )
        }
    } catch (e: Exception) {
        Result.Error(e.message ?: "Network error")
    }
}
