package com.cctn.app.ui.profile

import androidx.lifecycle.LiveData
import androidx.lifecycle.MutableLiveData
import androidx.lifecycle.ViewModel
import androidx.lifecycle.viewModelScope
import com.cctn.app.data.model.ProfileResponse
import com.cctn.app.data.model.UpdateProfileRequest
import com.cctn.app.data.repository.ProfileRepository
import com.cctn.app.util.Result
import dagger.hilt.android.lifecycle.HiltViewModel
import kotlinx.coroutines.launch
import javax.inject.Inject

@HiltViewModel
class ProfileViewModel @Inject constructor(private val repo: ProfileRepository) : ViewModel() {

    private val _profile = MutableLiveData<Result<ProfileResponse>>()
    val profile: LiveData<Result<ProfileResponse>> get() = _profile

    private val _updateResult = MutableLiveData<Result<ProfileResponse>>()
    val updateResult: LiveData<Result<ProfileResponse>> get() = _updateResult

    fun loadProfile() = viewModelScope.launch {
        _profile.value = Result.Loading
        _profile.value = repo.getProfile()
    }

    fun updateProfile(request: UpdateProfileRequest) = viewModelScope.launch {
        _updateResult.value = Result.Loading
        _updateResult.value = repo.updateProfile(request)
    }
}
