package com.cctn.app.data.api

import com.cctn.app.data.model.*
import retrofit2.Response
import retrofit2.http.*

interface ApiService {

    // ── Auth ──────────────────────────────────────────────────────────────────
    @POST("auth/login")
    suspend fun login(@Body body: LoginRequest): Response<AuthResponse>

    @POST("auth/register")
    suspend fun register(@Body body: RegisterRequest): Response<AuthResponse>

    @POST("auth/logout")
    suspend fun logout(): Response<GenericResponse>

    // ── Profile ───────────────────────────────────────────────────────────────
    @GET("profile")
    suspend fun getProfile(): Response<ProfileResponse>

    @PUT("profile")
    suspend fun updateProfile(@Body body: UpdateProfileRequest): Response<ProfileResponse>

    // ── Appointments ─────────────────────────────────────────────────────────
    @GET("appointments")
    suspend fun getAppointments(): Response<AppointmentsResponse>

    @GET("appointments/slots")
    suspend fun getSlots(@Query("date") date: String): Response<SlotsResponse>

    @POST("appointments")
    suspend fun bookAppointment(@Body body: BookAppointmentRequest): Response<AppointmentResponse>

    @DELETE("appointments/{id}")
    suspend fun cancelAppointment(@Path("id") id: Int): Response<GenericResponse>

    // ── Services ─────────────────────────────────────────────────────────────
    @GET("services")
    suspend fun getServices(): Response<ServicesResponse>

    // ── Billing ───────────────────────────────────────────────────────────────
    @GET("billing")
    suspend fun getBilling(): Response<BillingResponse>

    // ── Maintenance ───────────────────────────────────────────────────────────
    @GET("maintenance")
    suspend fun getMaintenance(): Response<MaintenanceResponse>

    @POST("maintenance")
    suspend fun submitMaintenance(@Body body: SubmitMaintenanceRequest): Response<MaintenanceSingleResponse>
}
