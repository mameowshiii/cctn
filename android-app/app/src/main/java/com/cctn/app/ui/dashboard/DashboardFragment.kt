package com.cctn.app.ui.dashboard

import android.os.Bundle
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.Toast
import androidx.fragment.app.Fragment
import androidx.fragment.app.viewModels
import androidx.navigation.fragment.findNavController
import coil.load
import coil.transform.CircleCropTransformation
import com.cctn.app.R
import com.cctn.app.databinding.FragmentDashboardBinding
import com.cctn.app.ui.auth.AuthViewModel
import com.cctn.app.util.Result
import dagger.hilt.android.AndroidEntryPoint

@AndroidEntryPoint
class DashboardFragment : Fragment() {

    private var _binding: FragmentDashboardBinding? = null
    private val binding get() = _binding!!
    private val viewModel: DashboardViewModel by viewModels()
    private val authViewModel: AuthViewModel by viewModels()

    override fun onCreateView(inflater: LayoutInflater, container: ViewGroup?, savedInstanceState: Bundle?): View {
        _binding = FragmentDashboardBinding.inflate(inflater, container, false)
        return binding.root
    }

    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)

        viewModel.loadDashboard()

        viewModel.profile.observe(viewLifecycleOwner) { result ->
            if (result is Result.Success) {
                val client = result.data.client ?: return@observe
                binding.tvWelcome.text = "Hello, ${client.firstname}! 👋"
                binding.tvAccountNumber.text = client.accountNumber
                binding.tvEmail.text = client.email
                client.profilePhoto?.let { url ->
                    binding.ivAvatar.load(url) {
                        crossfade(true)
                        transformations(CircleCropTransformation())
                        placeholder(R.drawable.ic_avatar_placeholder)
                    }
                }
            }
        }

        viewModel.appointments.observe(viewLifecycleOwner) { result ->
            if (result is Result.Success) {
                val list = result.data.appointments
                val total    = list.size
                val pending  = list.count { it.status == "pending" }
                val approved = list.count { it.status == "approved" }

                binding.tvTotalAppointments.text  = total.toString()
                binding.tvPendingAppointments.text  = pending.toString()
                binding.tvApprovedAppointments.text = approved.toString()
            }
        }

        binding.btnBookNow.setOnClickListener {
            findNavController().navigate(R.id.action_dashboardFragment_to_bookFragment)
        }

        binding.btnLogout.setOnClickListener {
            authViewModel.logout()
            findNavController().navigate(R.id.action_dashboardFragment_to_loginFragment)
        }
    }

    override fun onDestroyView() {
        super.onDestroyView()
        _binding = null
    }
}
