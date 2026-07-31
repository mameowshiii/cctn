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
            val errorBodyString = response.errorBody()?.string()
            val cleanMessage = parseErrorMessage(errorBodyString)
            Result.Error(cleanMessage, response.code())
        }
    } catch (e: Exception) {
        Result.Error(e.message ?: "Network error")
    }
}

private fun parseErrorMessage(errorBody: String?): String {
    if (errorBody.isNullOrEmpty()) return "Server error"
    return try {
        val jsonObject = org.json.JSONObject(errorBody)
        if (jsonObject.has("errors")) {
            val errorsObj = jsonObject.getJSONObject("errors")
            val keys = errorsObj.keys()
            if (keys.hasNext()) {
                val firstKey = keys.next()
                val errorsArray = errorsObj.getJSONArray(firstKey)
                if (errorsArray.length() > 0) {
                    return errorsArray.getString(0)
                }
            }
        }
        jsonObject.optString("message", "Server error")
    } catch (e: Exception) {
        errorBody
    }
}
