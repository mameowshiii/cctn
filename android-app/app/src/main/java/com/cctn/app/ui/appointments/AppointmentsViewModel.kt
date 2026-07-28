package com.cctn.app.ui.appointments

import androidx.lifecycle.LiveData
import androidx.lifecycle.MutableLiveData
import androidx.lifecycle.ViewModel
import androidx.lifecycle.viewModelScope
import com.cctn.app.data.model.*
import com.cctn.app.data.repository.AppointmentRepository
import com.cctn.app.util.Result
import dagger.hilt.android.lifecycle.HiltViewModel
import kotlinx.coroutines.launch
import javax.inject.Inject

@HiltViewModel
class AppointmentsViewModel @Inject constructor(
    private val repo: AppointmentRepository
) : ViewModel() {

    private val _appointments = MutableLiveData<Result<AppointmentsResponse>>()
    val appointments: LiveData<Result<AppointmentsResponse>> get() = _appointments

    private val _services = MutableLiveData<Result<ServicesResponse>>()
    val services: LiveData<Result<ServicesResponse>> get() = _services

    private val _slots = MutableLiveData<Result<SlotsResponse>>()
    val slots: LiveData<Result<SlotsResponse>> get() = _slots

    private val _bookResult = MutableLiveData<Result<AppointmentResponse>>()
    val bookResult: LiveData<Result<AppointmentResponse>> get() = _bookResult

    private val _cancelResult = MutableLiveData<Result<GenericResponse>>()
    val cancelResult: LiveData<Result<GenericResponse>> get() = _cancelResult

    fun loadAppointments() = viewModelScope.launch {
        _appointments.value = Result.Loading
        _appointments.value = repo.getAppointments()
    }

    fun loadServices() = viewModelScope.launch {
        _services.value = repo.getServices()
    }

    fun loadSlots(date: String) = viewModelScope.launch {
        _slots.value = Result.Loading
        _slots.value = repo.getSlots(date)
    }

    fun bookAppointment(serviceId: Int, date: String, time: String, message: String?) =
        viewModelScope.launch {
            _bookResult.value = Result.Loading
            _bookResult.value = repo.bookAppointment(serviceId, date, time, message)
        }

    fun cancelAppointment(id: Int) = viewModelScope.launch {
        _cancelResult.value = repo.cancelAppointment(id)
    }
}
