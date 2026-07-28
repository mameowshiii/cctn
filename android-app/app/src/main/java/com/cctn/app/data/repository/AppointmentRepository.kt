package com.cctn.app.data.repository

import com.cctn.app.data.api.ApiService
import com.cctn.app.data.model.*
import com.cctn.app.util.Result
import com.cctn.app.util.safeApiCall
import javax.inject.Inject
import javax.inject.Singleton

@Singleton
class AppointmentRepository @Inject constructor(private val api: ApiService) {

    suspend fun getAppointments(): Result<AppointmentsResponse> =
        safeApiCall { api.getAppointments() }

    suspend fun getSlots(date: String): Result<SlotsResponse> =
        safeApiCall { api.getSlots(date) }

    suspend fun bookAppointment(
        serviceId: Int,
        date: String,
        time: String,
        message: String?
    ): Result<AppointmentResponse> =
        safeApiCall { api.bookAppointment(BookAppointmentRequest(serviceId, date, time, message)) }

    suspend fun cancelAppointment(id: Int): Result<GenericResponse> =
        safeApiCall { api.cancelAppointment(id) }

    suspend fun getServices(): Result<ServicesResponse> =
        safeApiCall { api.getServices() }
}
