package com.cctn.app.ui.maintenance

import android.os.Bundle
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.Toast
import androidx.fragment.app.Fragment
import androidx.fragment.app.viewModels
import androidx.recyclerview.widget.LinearLayoutManager
import com.cctn.app.databinding.FragmentMaintenanceBinding
import com.cctn.app.util.Result
import dagger.hilt.android.AndroidEntryPoint

@AndroidEntryPoint
class MaintenanceFragment : Fragment() {

    private var _binding: FragmentMaintenanceBinding? = null
    private val binding get() = _binding!!
    private val viewModel: MaintenanceViewModel by viewModels()
    private lateinit var adapter: MaintenanceAdapter

    override fun onCreateView(inflater: LayoutInflater, container: ViewGroup?, savedInstanceState: Bundle?): View {
        _binding = FragmentMaintenanceBinding.inflate(inflater, container, false)
        return binding.root
    }

    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)

        adapter = MaintenanceAdapter()
        binding.rvRequests.layoutManager = LinearLayoutManager(requireContext())
        binding.rvRequests.adapter = adapter

        binding.swipeRefresh.setOnRefreshListener { viewModel.loadRequests() }

        // Submit new request
        binding.btnSubmit.setOnClickListener {
            val subject     = binding.etSubject.text.toString().trim()
            val description = binding.etDescription.text.toString().trim()
            val priority    = when (binding.rgPriority.checkedRadioButtonId) {
                binding.rbLow.id    -> "low"
                binding.rbHigh.id   -> "high"
                else                -> "medium"
            }
            if (subject.isEmpty() || description.isEmpty()) {
                Toast.makeText(requireContext(), "Please fill in subject and description.", Toast.LENGTH_SHORT).show()
                return@setOnClickListener
            }
            viewModel.submit(subject, description, priority)
        }

        viewModel.requests.observe(viewLifecycleOwner) { result ->
            binding.swipeRefresh.isRefreshing = result is Result.Loading
            if (result is Result.Success) {
                binding.emptyState.visibility = if (result.data.requests.isEmpty()) View.VISIBLE else View.GONE
                adapter.submitList(result.data.requests)
            }
        }

        viewModel.submitResult.observe(viewLifecycleOwner) { result ->
            when (result) {
                is Result.Loading -> binding.btnSubmit.isEnabled = false
                is Result.Success -> {
                    binding.btnSubmit.isEnabled = true
                    binding.etSubject.setText("")
                    binding.etDescription.setText("")
                    Toast.makeText(requireContext(), result.data.message, Toast.LENGTH_LONG).show()
                    viewModel.loadRequests()
                }
                is Result.Error -> {
                    binding.btnSubmit.isEnabled = true
                    Toast.makeText(requireContext(), result.message, Toast.LENGTH_LONG).show()
                }
            }
        }

        viewModel.loadRequests()
    }

    override fun onDestroyView() {
        super.onDestroyView()
        _binding = null
    }
}
