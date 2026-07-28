package com.cctn.app.ui.dashboard

import androidx.lifecycle.LiveData
import androidx.lifecycle.MutableLiveData
import androidx.lifecycle.ViewModel
import androidx.lifecycle.viewModelScope
import com.cctn.app.data.model.AppointmentsResponse
import com.cctn.app.data.model.ProfileResponse
import com.cctn.app.data.prefs.TokenManager
import com.cctn.app.data.repository.AppointmentRepository
import com.cctn.app.data.repository.ProfileRepository
import com.cctn.app.util.Result
import dagger.hilt.android.lifecycle.HiltViewModel
import kotlinx.coroutines.launch
import javax.inject.Inject

@HiltViewModel
class DashboardViewModel @Inject constructor(
    private val profileRepo: ProfileRepository,
    private val appointmentRepo: AppointmentRepository,
    val tokenManager: TokenManager
) : ViewModel() {

    private val _profile = MutableLiveData<Result<ProfileResponse>>()
    val profile: LiveData<Result<ProfileResponse>> get() = _profile

    private val _appointments = MutableLiveData<Result<AppointmentsResponse>>()
    val appointments: LiveData<Result<AppointmentsResponse>> get() = _appointments

    fun loadDashboard() {
        viewModelScope.launch { _profile.value = profileRepo.getProfile() }
        viewModelScope.launch { _appointments.value = appointmentRepo.getAppointments() }
    }
}
