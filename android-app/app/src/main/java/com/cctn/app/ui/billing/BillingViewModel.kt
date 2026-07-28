package com.cctn.app.ui.billing

import androidx.lifecycle.LiveData
import androidx.lifecycle.MutableLiveData
import androidx.lifecycle.ViewModel
import androidx.lifecycle.viewModelScope
import com.cctn.app.data.model.BillingResponse
import com.cctn.app.data.repository.BillingRepository
import com.cctn.app.util.Result
import dagger.hilt.android.lifecycle.HiltViewModel
import kotlinx.coroutines.launch
import javax.inject.Inject

@HiltViewModel
class BillingViewModel @Inject constructor(private val repo: BillingRepository) : ViewModel() {

    private val _billing = MutableLiveData<Result<BillingResponse>>()
    val billing: LiveData<Result<BillingResponse>> get() = _billing

    fun loadBilling() = viewModelScope.launch {
        _billing.value = Result.Loading
        _billing.value = repo.getBilling()
    }
}
