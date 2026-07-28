package com.cctn.app.ui.appointments

import android.os.Bundle
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.Toast
import androidx.core.content.ContextCompat
import androidx.fragment.app.Fragment
import androidx.fragment.app.viewModels
import androidx.navigation.fragment.findNavController
import androidx.recyclerview.widget.LinearLayoutManager
import com.cctn.app.R
import com.cctn.app.databinding.FragmentAppointmentsBinding
import com.cctn.app.util.Result
import dagger.hilt.android.AndroidEntryPoint

@AndroidEntryPoint
class AppointmentsFragment : Fragment() {

    private var _binding: FragmentAppointmentsBinding? = null
    private val binding get() = _binding!!
    private val viewModel: AppointmentsViewModel by viewModels()
    private lateinit var adapter: AppointmentsAdapter

    override fun onCreateView(inflater: LayoutInflater, container: ViewGroup?, savedInstanceState: Bundle?): View {
        _binding = FragmentAppointmentsBinding.inflate(inflater, container, false)
        return binding.root
    }

    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)

        adapter = AppointmentsAdapter { appointment ->
            if (appointment.status == "pending") {
                viewModel.cancelAppointment(appointment.id)
            } else {
                Toast.makeText(requireContext(), "Only pending appointments can be cancelled.", Toast.LENGTH_SHORT).show()
            }
        }

        binding.rvAppointments.layoutManager = LinearLayoutManager(requireContext())
        binding.rvAppointments.adapter = adapter

        binding.btnBook.setOnClickListener {
            findNavController().navigate(R.id.action_appointmentsFragment_to_bookFragment)
        }

        binding.swipeRefresh.setOnRefreshListener { viewModel.loadAppointments() }

        viewModel.appointments.observe(viewLifecycleOwner) { result ->
            binding.swipeRefresh.isRefreshing = result is Result.Loading
            when (result) {
                is Result.Success -> {
                    binding.emptyState.visibility =
                        if (result.data.appointments.isEmpty()) View.VISIBLE else View.GONE
                    adapter.submitList(result.data.appointments)
                }
                is Result.Error -> {
                    Toast.makeText(requireContext(), result.message, Toast.LENGTH_LONG).show()
                }
                else -> {}
            }
        }

        viewModel.cancelResult.observe(viewLifecycleOwner) { result ->
            if (result is Result.Success) {
                Toast.makeText(requireContext(), "Appointment cancelled.", Toast.LENGTH_SHORT).show()
                viewModel.loadAppointments()
            } else if (result is Result.Error) {
                Toast.makeText(requireContext(), result.message, Toast.LENGTH_LONG).show()
            }
        }

        viewModel.loadAppointments()
    }

    override fun onDestroyView() {
        super.onDestroyView()
        _binding = null
    }
}
