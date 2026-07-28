package com.cctn.app.ui.appointments

import android.app.DatePickerDialog
import android.os.Bundle
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.ArrayAdapter
import android.widget.Toast
import androidx.fragment.app.Fragment
import androidx.fragment.app.viewModels
import androidx.navigation.fragment.findNavController
import com.cctn.app.data.model.ServiceModel
import com.cctn.app.data.model.TimeSlotModel
import com.cctn.app.databinding.FragmentBookBinding
import com.cctn.app.util.Result
import dagger.hilt.android.AndroidEntryPoint
import java.util.*

@AndroidEntryPoint
class BookFragment : Fragment() {

    private var _binding: FragmentBookBinding? = null
    private val binding get() = _binding!!
    private val viewModel: AppointmentsViewModel by viewModels()

    private var selectedDate: String = ""
    private var selectedTime: String = ""
    private var selectedServiceId: Int = -1
    private var serviceList: List<ServiceModel> = emptyList()
    private var slotList: List<TimeSlotModel> = emptyList()

    override fun onCreateView(inflater: LayoutInflater, container: ViewGroup?, savedInstanceState: Bundle?): View {
        _binding = FragmentBookBinding.inflate(inflater, container, false)
        return binding.root
    }

    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)

        viewModel.loadServices()

        // Set default date to tomorrow
        val cal = Calendar.getInstance().apply { add(Calendar.DAY_OF_YEAR, 1) }
        selectedDate = String.format("%04d-%02d-%02d", cal.get(Calendar.YEAR), cal.get(Calendar.MONTH) + 1, cal.get(Calendar.DAY_OF_MONTH))
        binding.etDate.setText(selectedDate)
        viewModel.loadSlots(selectedDate)

        // Date picker
        binding.etDate.setOnClickListener {
            val now = Calendar.getInstance()
            DatePickerDialog(requireContext(), { _, y, m, d ->
                selectedDate = String.format("%04d-%02d-%02d", y, m + 1, d)
                binding.etDate.setText(selectedDate)
                viewModel.loadSlots(selectedDate)
            }, now.get(Calendar.YEAR), now.get(Calendar.MONTH), now.get(Calendar.DAY_OF_MONTH)).show()
        }

        // Services spinner
        viewModel.services.observe(viewLifecycleOwner) { result ->
            if (result is Result.Success) {
                serviceList = result.data.services
                val names = serviceList.map { "${it.serviceName} — ₱${String.format("%.2f", it.price)}" }
                val adapter = ArrayAdapter(requireContext(), android.R.layout.simple_spinner_item, names)
                adapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item)
                binding.spinnerService.adapter = adapter
            }
        }

        // Time slots
        viewModel.slots.observe(viewLifecycleOwner) { result ->
            when (result) {
                is Result.Loading -> binding.slotGroup.removeAllViews()
                is Result.Success -> {
                    slotList = result.data.slots
                    renderSlots(slotList)
                }
                is Result.Error -> {
                    Toast.makeText(requireContext(), result.message, Toast.LENGTH_SHORT).show()
                }
            }
        }

        // Book button
        binding.btnBook.setOnClickListener {
            val serviceIndex = binding.spinnerService.selectedItemPosition
            if (serviceIndex < 0 || serviceList.isEmpty()) {
                Toast.makeText(requireContext(), "Please select a service.", Toast.LENGTH_SHORT).show()
                return@setOnClickListener
            }
            if (selectedTime.isEmpty()) {
                Toast.makeText(requireContext(), "Please select a time slot.", Toast.LENGTH_SHORT).show()
                return@setOnClickListener
            }

            selectedServiceId = serviceList[serviceIndex].id
            val message = binding.etMessage.text.toString().trim().ifEmpty { null }
            viewModel.bookAppointment(selectedServiceId, selectedDate, selectedTime, message)
        }

        viewModel.bookResult.observe(viewLifecycleOwner) { result ->
            when (result) {
                is Result.Loading -> binding.btnBook.isEnabled = false
                is Result.Success -> {
                    binding.btnBook.isEnabled = true
                    val msg = if (result.data.rescheduled == true)
                        "⚠️ Auto-rescheduled: ${result.data.message}"
                    else
                        "✅ ${result.data.message}"
                    Toast.makeText(requireContext(), msg, Toast.LENGTH_LONG).show()
                    findNavController().navigateUp()
                }
                is Result.Error -> {
                    binding.btnBook.isEnabled = true
                    Toast.makeText(requireContext(), result.message, Toast.LENGTH_LONG).show()
                }
            }
        }
    }

    private fun renderSlots(slots: List<TimeSlotModel>) {
        binding.slotGroup.removeAllViews()
        slots.forEach { slot ->
            val btn = com.google.android.material.button.MaterialButton(requireContext()).apply {
                text = slot.label
                isEnabled = slot.available
                strokeWidth = 2
                setOnClickListener {
                    selectedTime = slot.time
                    binding.tvSelectedSlot.text = "Selected: ${slot.label}"
                }
            }
            binding.slotGroup.addView(btn)
        }
    }

    override fun onDestroyView() {
        super.onDestroyView()
        _binding = null
    }
}
