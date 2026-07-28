package com.cctn.app.ui.maintenance

import androidx.lifecycle.LiveData
import androidx.lifecycle.MutableLiveData
import androidx.lifecycle.ViewModel
import androidx.lifecycle.viewModelScope
import com.cctn.app.data.model.MaintenanceResponse
import com.cctn.app.data.model.MaintenanceSingleResponse
import com.cctn.app.data.repository.MaintenanceRepository
import com.cctn.app.util.Result
import dagger.hilt.android.lifecycle.HiltViewModel
import kotlinx.coroutines.launch
import javax.inject.Inject

@HiltViewModel
class MaintenanceViewModel @Inject constructor(private val repo: MaintenanceRepository) : ViewModel() {

    private val _requests = MutableLiveData<Result<MaintenanceResponse>>()
    val requests: LiveData<Result<MaintenanceResponse>> get() = _requests

    private val _submitResult = MutableLiveData<Result<MaintenanceSingleResponse>>()
    val submitResult: LiveData<Result<MaintenanceSingleResponse>> get() = _submitResult

    fun loadRequests() = viewModelScope.launch {
        _requests.value = Result.Loading
        _requests.value = repo.getMaintenance()
    }

    fun submit(subject: String, description: String, priority: String) = viewModelScope.launch {
        _submitResult.value = Result.Loading
        _submitResult.value = repo.submit(subject, description, priority)
    }
}
