package com.cctn.app.data.model

import com.squareup.moshi.Json
import com.squareup.moshi.JsonClass

// ─── Auth ─────────────────────────────────────────────────────────────────────

@JsonClass(generateAdapter = true)
data class LoginRequest(
    @Json(name = "login_input") val loginInput: String,
    val password: String
)

@JsonClass(generateAdapter = true)
data class RegisterRequest(
    val firstname: String,
    val middlename: String? = null,
    val lastname: String,
    val email: String,
    val username: String,
    val password: String,
    @Json(name = "password_confirmation") val passwordConfirmation: String,
    @Json(name = "contact_no") val contactNo: String,
    @Json(name = "address_barangay") val addressBarangay: String,
    @Json(name = "address_municipality") val addressMunicipality: String,
    @Json(name = "address_province") val addressProvince: String,
    val birthdate: String? = null,
    val gender: String? = null,
)

@JsonClass(generateAdapter = true)
data class AuthResponse(
    val success: Boolean,
    val message: String,
    val token: String?,
    val client: ClientModel?
)

// ─── Client / Profile ─────────────────────────────────────────────────────────

@JsonClass(generateAdapter = true)
data class ClientModel(
    val id: Int,
    @Json(name = "account_number") val accountNumber: String,
    val firstname: String,
    val middlename: String?,
    val lastname: String,
    @Json(name = "full_name") val fullName: String,
    val email: String,
    val username: String,
    val birthdate: String?,
    val age: Int?,
    val gender: String?,
    @Json(name = "civil_status") val civilStatus: String?,
    @Json(name = "place_of_birth") val placeOfBirth: String?,
    @Json(name = "address_barangay") val addressBarangay: String?,
    @Json(name = "address_municipality") val addressMunicipality: String?,
    @Json(name = "address_province") val addressProvince: String?,
    @Json(name = "contact_no") val contactNo: String?,
    @Json(name = "profile_photo") val profilePhoto: String?,
    @Json(name = "created_at") val createdAt: String?
)

@JsonClass(generateAdapter = true)
data class ProfileResponse(
    val success: Boolean,
    val client: ClientModel?
)

@JsonClass(generateAdapter = true)
data class UpdateProfileRequest(
    val firstname: String,
    val middlename: String? = null,
    val lastname: String,
    val email: String,
    val username: String,
    @Json(name = "contact_no") val contactNo: String,
    val birthdate: String? = null,
    val gender: String? = null,
    @Json(name = "civil_status") val civilStatus: String? = null,
    @Json(name = "address_barangay") val addressBarangay: String? = null,
    @Json(name = "address_municipality") val addressMunicipality: String? = null,
    @Json(name = "address_province") val addressProvince: String? = null,
    @Json(name = "new_password") val newPassword: String? = null,
)

// ─── Appointment ──────────────────────────────────────────────────────────────

@JsonClass(generateAdapter = true)
data class AppointmentModel(
    val id: Int,
    val service: ServiceSummary?,
    @Json(name = "preferred_date") val preferredDate: String?,
    @Json(name = "preferred_time") val preferredTime: String?,
    val message: String?,
    val status: String,
    @Json(name = "admin_notes") val adminNotes: String?,
    @Json(name = "created_at") val createdAt: String?
)

@JsonClass(generateAdapter = true)
data class ServiceSummary(
    val id: Int,
    val name: String,
    val price: Double,
    @Json(name = "duration_min") val durationMin: Int
)

@JsonClass(generateAdapter = true)
data class AppointmentsResponse(
    val success: Boolean,
    val appointments: List<AppointmentModel>
)

@JsonClass(generateAdapter = true)
data class BookAppointmentRequest(
    @Json(name = "service_id") val serviceId: Int,
    @Json(name = "preferred_date") val preferredDate: String,
    @Json(name = "preferred_time") val preferredTime: String,
    val message: String? = null
)

@JsonClass(generateAdapter = true)
data class AppointmentResponse(
    val success: Boolean,
    val rescheduled: Boolean?,
    val message: String,
    val appointment: AppointmentModel?
)

// ─── Time Slots ──────────────────────────────────────────────────────────────

@JsonClass(generateAdapter = true)
data class TimeSlotModel(
    val time: String,
    val label: String,
    val available: Boolean
)

@JsonClass(generateAdapter = true)
data class SlotsResponse(
    val success: Boolean,
    val date: String,
    val slots: List<TimeSlotModel>
)

// ─── Service ─────────────────────────────────────────────────────────────────

@JsonClass(generateAdapter = true)
data class ServiceModel(
    val id: Int,
    @Json(name = "service_name") val serviceName: String,
    val description: String?,
    val price: Double,
    @Json(name = "duration_minutes") val durationMinutes: Int,
    val status: String
)

@JsonClass(generateAdapter = true)
data class ServicesResponse(
    val success: Boolean,
    val services: List<ServiceModel>
)

// ─── Billing ─────────────────────────────────────────────────────────────────

@JsonClass(generateAdapter = true)
data class BillingModel(
    val id: Int,
    @Json(name = "account_number") val accountNumber: String?,
    @Json(name = "statement_period") val statementPeriod: String?,
    @Json(name = "amount_due") val amountDue: Double,
    @Json(name = "penalty_amount") val penaltyAmount: Double,
    @Json(name = "total_amount_due") val totalAmountDue: Double,
    val status: String,
    @Json(name = "due_date") val dueDate: String?,
    @Json(name = "paid_at") val paidAt: String?,
    val notes: String?
)

@JsonClass(generateAdapter = true)
data class BillingResponse(
    val success: Boolean,
    val balance: Double,
    val statements: List<BillingModel>
)

// ─── Maintenance ─────────────────────────────────────────────────────────────

@JsonClass(generateAdapter = true)
data class MaintenanceModel(
    val id: Int,
    val subject: String,
    val description: String?,
    val priority: String,
    val status: String,
    @Json(name = "follow_up_note") val followUpNote: String?,
    @Json(name = "created_at") val createdAt: String?
)

@JsonClass(generateAdapter = true)
data class MaintenanceResponse(
    val success: Boolean,
    val requests: List<MaintenanceModel>
)

@JsonClass(generateAdapter = true)
data class SubmitMaintenanceRequest(
    val subject: String,
    val description: String,
    val priority: String
)

@JsonClass(generateAdapter = true)
data class MaintenanceSingleResponse(
    val success: Boolean,
    val message: String,
    @Json(name = "request") val request: MaintenanceModel?
)

// ─── Generic ─────────────────────────────────────────────────────────────────

@JsonClass(generateAdapter = true)
data class GenericResponse(
    val success: Boolean,
    val message: String
)
