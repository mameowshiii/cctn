package com.cctn.app.data.repository

import com.cctn.app.data.api.ApiService
import com.cctn.app.data.model.*
import com.cctn.app.util.Result
import com.cctn.app.util.safeApiCall
import javax.inject.Inject
import javax.inject.Singleton

@Singleton
class ProfileRepository @Inject constructor(private val api: ApiService) {

    suspend fun getProfile(): Result<ProfileResponse> =
        safeApiCall { api.getProfile() }

    suspend fun updateProfile(request: UpdateProfileRequest): Result<ProfileResponse> =
        safeApiCall { api.updateProfile(request) }
}

@Singleton
class BillingRepository @Inject constructor(private val api: ApiService) {

    suspend fun getBilling(): Result<BillingResponse> =
        safeApiCall { api.getBilling() }
}

@Singleton
class MaintenanceRepository @Inject constructor(private val api: ApiService) {

    suspend fun getMaintenance(): Result<MaintenanceResponse> =
        safeApiCall { api.getMaintenance() }

    suspend fun submit(subject: String, description: String, priority: String): Result<MaintenanceSingleResponse> =
        safeApiCall { api.submitMaintenance(SubmitMaintenanceRequest(subject, description, priority)) }
}
